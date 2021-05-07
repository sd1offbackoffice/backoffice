@extends('navbar')
@section('title','MASTER | MASTER MEMBER')
@section('content')


    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body">
                        <div class="row text-right">
                            <div class="col-sm-12">
                                <div class="form-group row mb-0">
                                    <label for="cus_kodemember" class="col-sm-2 col-form-label">Nomor Anggota</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control diisi" id="cus_kodemember">
                                        <button id="btn-modal-member" type="button" class="btn btn-lov p-0"  data-toggle="modal" data-target="#m_kodememberHelp">
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                        </button>
                                    </div>
{{--                                    <div class="col-sm-2">--}}
{{--                                        <input type="text" class="form-control diisi" id="cus_kodemember">--}}
{{--                                    </div>--}}
{{--                                    <div class="col-sm-1 p-0">--}}
{{--                                        <button type="button" id="btn-modal-member" class="btn p-0 float-left" data-toggle="modal" data-target="#m_kodememberHelp"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>--}}
{{--                                    </div>--}}

                                    <div class="col-sm-3 text-center">
                                        <div id="segment" class="segment rounded" style="display:none">
                                            <label class="col-form-label">MEMBER PLATINUM</label>
                                        </div>
                                    </div>
                                    <label for="i_statusmember" class="col-sm-1 col-form-label">Status</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="i_statusmember">
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="cus_namamember" class="col-sm-2 col-form-label wajib">Nama Anggota<span class="wajib">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control diisi" id="cus_namamember">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs custom-color" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="btn-p_identitas" data-toggle="tab" href="#p_identitas">Identitas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="btn-p_identitas2" data-toggle="tab" href="#p_identitas2">Identitas 2</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="btn-p_identitas3" data-toggle="tab" href="#p_identitas3">Identitas 3</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="btn-p_hobby" data-toggle="tab" href="#p_hobby">Hobby</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="btn-p_npwp" data-toggle="tab" href="#p_alamatnpwp">Alamat NPWP</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="btn-p_fasilitasbank" data-toggle="tab" href="#p_fasilitasbank">Fasilitas Perbankan</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div id="p_identitas" class="container tab-pane active pl-0 pr-0 fix-height">
                            <div class="card-body ">
                                <div class="row text-right">
                                    <div class="col-sm-12">
                                        <div class="form-group row mb-0">
                                            <label for="cus_noktp" class="col-sm-2 col-form-label">No. KTP<span class="wajib">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="number" class="form-control diisi" id="cus_noktp">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_alamatmember1" class="col-sm-2 col-form-label">Alamat KTP<span class="wajib">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control diisi" id="cus_alamatmember1">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_alamatmember4" class="col-sm-2 col-form-label">Kelurahan<span class="wajib">*</span></label>
                                            <div class="col-sm-3 buttonInside">
                                                <input type="text" class="form-control diisi" id="cus_alamatmember4">
                                                <button id="btn-modal-ktp" type="button" class="btn btn-lov p-0"  data-toggle="modal" data-target="#m_kodeposHelp">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>

{{--                                            <div class="col-sm-3">--}}
{{--                                                <input type="text" class="form-control diisi" id="cus_alamatmember4">--}}
{{--                                            </div>--}}
{{--                                            <div class="col-sm-1 p-0">--}}
{{--                                                <button id="btn-modal-ktp" type="button" class="btn p-0 float-left" data-toggle="modal" data-target="#m_kodeposHelp"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>--}}
{{--                                            </div>--}}
                                            <label for="i_kecamatanktp" class="col-sm-3 col-form-label">Kecamatan<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi" id="i_kecamatanktp">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_alamatmember3" class="col-sm-2 col-form-label">Kode Pos<span class="wajib">*</span></label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control diisi" id="cus_alamatmember3">
                                            </div>
                                            <label for="cus_alamatmember2" class="col-sm-4 col-form-label">Kota<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi" id="cus_alamatmember2">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_alamatmember5" class="col-sm-2 col-form-label">Alamat Surat<span class="wajib">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control diisi" id="cus_alamatmember5">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_alamatmember8" class="col-sm-2 col-form-label">Kelurahan<span class="wajib">*</span></label>
                                            <div class="col-sm-3 buttonInside">
                                                <input type="text" class="form-control diisi" id="cus_alamatmember8">
                                                <button id="btn-modal-surat" type="button" class="btn btn-lov p-0"  data-toggle="modal" data-target="#m_kodeposHelp">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>

{{--                                            <div class="col-sm-3">--}}
{{--                                                <input type="text" class="form-control diisi" id="cus_alamatmember8">--}}
{{--                                            </div>--}}
{{--                                            <div class="col-sm-1 p-0">--}}
{{--                                                <button id="btn-modal-surat" type="button" class="btn p-0 float-left" data-toggle="modal" data-target="#m_kodeposHelp"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>--}}
{{--                                            </div>--}}
                                            <label for="i_kecamatansurat" class="col-sm-3 col-form-label">Kecamatan<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi" id="i_kecamatansurat">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_alamatmember7" class="col-sm-2 col-form-label">Kode Pos<span class="wajib">*</span></label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control diisi" id="cus_alamatmember7">
                                            </div>
                                            <label for="cus_alamatmember6" class="col-sm-4 col-form-label">Kota<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi" id="cus_alamatmember6">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_tlpmember" class="col-sm-2 col-form-label">Telepon<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi" id="cus_tlpmember">
                                            </div>
                                            <label for="cus_hpmember" class="col-sm-3 col-form-label">HP<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi" id="cus_hpmember">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_tmptlahir" class="col-sm-2 col-form-label">Tempat Lahir<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi" id="crm_tmptlahir">
                                            </div>
                                            <label for="cus_tgllahir" class="col-sm-3 col-form-label">Tgl. Lahir<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi" id="cus_tgllahir" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_jeniscustomer" class="col-sm-2 col-form-label">Jenis Customer</label>
                                            <div class="col-sm-1 buttonInside">
                                                <input type="text" class="form-control diisi" id="cus_jenismember">
                                                <button id="btn-modal-surat" type="button" class="btn btn-lov p-0"  data-toggle="modal" data-target="#m_jenismemberHelp">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>


{{--                                            <div class="col-sm-1 pr-0">--}}
{{--                                                <input type="text" class="form-control" id="cus_jenismember">--}}
{{--                                            </div>--}}
                                            <div class="col-sm-2 pl-0">
                                                <input type="text" class="form-control" id="i_jeniscustomer2">
                                            </div>
{{--                                            <div class="col-sm-1 p-0">--}}
{{--                                                <button type="button" class="btn p-0 float-left" data-toggle="modal" data-target="#m_jenismemberHelp"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>--}}
{{--                                            </div>--}}
                                            <label for="i_jenisoutlet" class="col-sm-2 offset-sm-1 col-form-label">Jenis Outlet</label>
                                            <div class="col-sm-1 buttonInside">
                                                <input type="text" class="form-control diisi" id="cus_kodeoutlet">
                                                <button id="btn-modal-surat" type="button" class="btn btn-lov p-0"  data-toggle="modal" data-target="#m_jenisoutletHelp">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>

{{--                                            <div class="col-sm-1 pr-0">--}}
{{--                                                <input type="text" class="form-control" id="cus_kodeoutlet">--}}
{{--                                            </div>--}}
                                            <div class="col-sm-2 pl-0">
                                                <input type="text" class="form-control" id="i_jenisoutlet2">
                                            </div>
{{--                                            <div class="col-sm-1 p-0">--}}
{{--                                                <button type="button" class="btn p-0 float-left" data-toggle="modal" data-target="#m_jenisoutletHelp"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>--}}
{{--                                            </div>--}}
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_jarak" class="col-sm-2 col-form-label">Jarak</label>
                                            <div class="col-sm-2">
                                                <input type="number" min="0" class="form-control" id="cus_jarak">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_flagpkp" class="col-sm-2 col-form-label">PKP</label>
                                            <div class="col-sm-1">
                                                <input type="text" maxlength="1" class="form-control" id="cus_flagpkp">
                                            </div>
                                            <label for="cus_flagpkp" class="col-sm-1 col-form-label pl-0 text-left">[ Y / T ]</label>
                                            <label for="cus_npwp" class="col-sm-4 col-form-label">NPWP</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="cus_npwp">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_flagkredit" class="col-sm-2 col-form-label">Flag Kredit</label>
                                            <div class="col-sm-1">
                                                <input type="text" maxlength="1" class="form-control" id="cus_flagkredit">
                                            </div>
                                            <label for="cus_flagkredit" class="col-sm-1 col-form-label pl-0 text-left">[ Y / T ]</label>
                                            <label for="cus_creditlimit" class="col-sm-1 col-form-label">Limit</label>
                                            <div class="col-sm-2">
                                                <input type="number" min="0" class="form-control" id="cus_creditlimit">
                                            </div>
                                            <label for="cus_top" class="col-sm-1 col-form-label">TOP</label>
                                            <div class="col-sm-1">
                                                <input type="number" min="0" class="form-control" id="cus_top">
                                            </div>
                                            <label for="cus_creditlimit" class="col-sm-1 col-form-label text-left pl-0">Hari</label>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_nosalesman" class="col-sm-2 col-form-label">Salesman</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="cus_nosalesman">
                                            </div>
                                            <label for="cus_flagmemberkhusus" class="col-sm-4 col-form-label">Member Khusus</label>
                                            <div class="col-sm-1">
                                                <input type="text" maxlength="1" class="form-control" id="cus_flagmemberkhusus">
                                            </div>
                                            <label for="cus_flagpkp" class="col-sm-1 col-form-label pl-0 text-left">[ Y /  ]</label>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_flagkirimsms" class="col-sm-2 col-form-label">Kirim SMS</label>
                                            <div class="col-sm-1">
                                                <input type="text" maxlength="1" class="form-control" id="cus_flagkirimsms">
                                            </div>
                                            <label for="cus_flagkirimsms" class="col-sm-1 col-form-label pl-0 text-left">[ Y / T ]</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="p_identitas2" class="container tab-pane fade pl-0 pr-0 fix-height">
                            <div class="card-body ">
                                <div class="row text-right">
                                    <div class="col-sm-12">
                                        <div class="form-group row mb-0">
                                            <label for="grp_group" class="col-sm-2 col-form-label">Group<span class="wajib">*</span></label>
                                            <div class="col-sm-2 buttonInside">
                                                <input type="text" class="form-control diisi" id="grp_group">
                                                <button id="btn-modal-group" type="button" class="btn btn-lov p-0"  data-toggle="modal" data-target="#m_groupHelp">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>

{{--                                            <div class="col-sm-2">--}}
{{--                                                <input type="text" class="form-control diisi" id="grp_group">--}}
{{--                                            </div>--}}
{{--                                            <div class="col-sm-1 p-0">--}}
{{--                                                <button id="btn-modal-group" type="button" class="btn p-0 float-left" data-toggle="modal" data-target="#m_groupHelp"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>--}}
{{--                                            </div>--}}
                                            <label for="grp_kategori" class="col-sm-4 col-form-label">Kategori</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi" id="grp_kategori">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="grp_subgroup" class="col-sm-2 col-form-label">Sub Group</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi" id="grp_subgroup">
                                            </div>
                                            <label for="grp_subkategori" class="col-sm-3 col-form-label">Sub Kategori</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi" id="grp_subkategori">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_jenisanggota" class="col-sm-2 col-form-label">Jenis Anggota<span class="wajib">*</span></label>
                                            <div class="col-sm-1">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input diisi_cb" id="cb_jenisanggotaR">
                                                    <label class="custom-control-label" for="cb_jenisanggotaR">Regular</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input diisi_cb" id="cb_jenisanggotaK">
                                                    <label class="custom-control-label" for="cb_jenisanggotaK">Khusus</label>
                                                </div>
                                            </div>
                                            <label for="i_jeniskelamin" class="col-sm-4 col-form-label">Jenis Kelamin<span class="wajib">*</span></label>
                                            <div class="col-sm-2">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="checkbox-inline custom-control-input diisi_cb" id="cb_jeniskelaminL">
                                                    <label class="custom-control-label" for="cb_jeniskelaminL">Laki-laki</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input diisi_cb" id="cb_jeniskelaminP">
                                                    <label class="custom-control-label" for="cb_jeniskelaminP">Perempuan</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_pic1" class="col-sm-2 col-form-label">Contact Person 1</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="crm_pic1">
                                            </div>
                                            <label for="crm_nohppic1" class="col-sm-2 col-form-label">No. HP 1</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="crm_nohppic1">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_pic2" class="col-sm-2 col-form-label">Contact Person 2</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="crm_pic2">
                                            </div>
                                            <label for="crm_nohppic2" class="col-sm-2 col-form-label">No. HP 2</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="crm_nohppic2">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_email" class="col-sm-2 col-form-label">Alamat Email<span class="wajib">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="email" class="form-control diisi" id="crm_email">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_agama" class="col-sm-2 col-form-label">Agama<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <select class="browser-default custom-select diisi" id="crm_agama">
                                                    <option selected disabled>Pilih Agama</option>
                                                    <option value="ISLAM">Islam</option>
                                                    <option value="KRISTEN">Kristen</option>
                                                    <option value="KATHOLIK">Katholik</option>
                                                    <option value="BUDHA">Budha</option>
                                                    <option value="HINDU">Hindu</option>
                                                    <option value="ALIRAN">Aliran Kepercayaan</option>
                                                </select>
                                            </div>
                                            <label for="crm_pekerjaan" class="col-sm-3 col-form-label">Pekerjaan</label>
                                            <div class="col-sm-3">
                                                <select class="browser-default custom-select" id="crm_pekerjaan">
                                                    <option selected disabled>Pilih Pekerjaan</option>
                                                    <option value="wiraswasta">Wiraswasta</option>
                                                    <option value="pegawainegeri">Pegawai Negeri</option>
                                                    <option value="pegawaiswasta">Pegawai Swasta</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_namapasangan" class="col-sm-2 col-form-label">Nama Suami / Istri</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="crm_namapasangan">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_tgllhrpasangan" class="col-sm-2 col-form-label">Tgl. Lahir Pasangan</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="crm_tgllhrpasangan" readonly>
                                            </div>
                                            <label for="crm_jmlanak" class="col-sm-3 col-form-label">Jumlah Anak</label>
                                            <div class="col-sm-1">
                                                <input type="number" min="0" class="form-control" id="crm_jmlanak">
                                            </div>
                                            <label for="crm_jmlanak" class="col-sm-1 pl-0 text-left col-form-label">Anak</label>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_pendidikan" class="col-sm-2 col-form-label">Pendidikan Terakhir</label>
                                            <div class="col-sm-3">
                                                <select class="browser-default custom-select" id="i_pendidikan">
                                                    <option selected disabled>...</option>
                                                    <option value="SD">SD</option>
                                                    <option value="SLTP">SLTP</option>
                                                    <option value="SLTA">SLTA</option>
                                                    <option value="S-1">S-1</option>
                                                    <option value="S-2">S-2</option>
                                                    <option value="S-3">S-3</option>
                                                    <option value="X">Lainnya</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4 pl-0">
                                                <input type="text" class="form-control" id="i_pendidikanX">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_nofax" class="col-sm-2 col-form-label">No. F</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="crm_nofax">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_internet" class="col-sm-5 col-form-label">Apakah HP Anda menggunakan Layanan Data / Internet<span class="wajib">*</span></label>
                                            <div class="col-sm-1">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input diisi_cb" id="cb_internetY">
                                                    <label class="custom-control-label" for="cb_internetY">Ya</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input diisi_cb" id="cb_internetT">
                                                    <label class="custom-control-label" for="cb_internetT">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_tipehp" class="col-sm-5 col-form-label">Merk dan Tipe HP yang digunakan</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="crm_tipehp">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_namabank" class="col-sm-5 col-form-label">Bank yang sekarang digunakan<span class="wajib">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control diisi" id="crm_namabank">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="c_metodekirim" class="col-sm-5 col-form-label">Metode yang paling disukai dalam<br> menyampaikan informasi<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <select class="browser-default custom-select diisi" id="c_metodekirim">
                                                    <option selected disabled>...</option>
                                                    <option value="POSR">Pos ke alamat rumah</option>
                                                    <option value="POSK">Pos ke alamat tempat usaha</option>
                                                    <option value="EMAIL">e-mail</option>
                                                    <option value="SMS">SMS</option>
                                                    <option value="X">Lainnya</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3 pl-0">
                                                <input type="text" class="form-control" id="c_metodekirimX">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_koordinat" class="col-sm-5 col-form-label">Koordinat Tempat Usaha</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="i_koordinat">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="p_identitas3" class="container tab-pane fade pl-0 pr-0 fix-height">
                            <div class="card-body ">
                                <div class="row text-right">
                                    <div class="col-sm-12">
                                        <div class="form-group row mb-0">
                                            <label for="crm_alamatusaha1" class="col-sm-2 pl-0 col-form-label">Alamat Tempat Usaha<span class="wajib">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control diisi" id="crm_alamatusaha1">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_alamatusaha4" class="col-sm-2 col-form-label">Kelurahan<span class="wajib">*</span></label>
                                            <div class="col-sm-3 buttonInside">
                                                <input type="text" class="form-control diisi" id="crm_alamatusaha4">
                                                <button id="btn-modal-usaha" type="button" class="btn btn-lov p-0"  data-toggle="modal" data-target="#m_kodeposHelp">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>

{{--                                            <div class="col-sm-3">--}}
{{--                                                <input type="text" class="form-control diisi" id="crm_alamatusaha4">--}}
{{--                                            </div>--}}
{{--                                            <div class="col-sm-1 p-0">--}}
{{--                                                <button id="btn-modal-usaha" type="button" class="btn p-0 float-left" data-toggle="modal" data-target="#m_kodeposHelp"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>--}}
{{--                                            </div>--}}
                                            <label for="pos_kecamatan" class="col-sm-3 col-form-label">Kecamatan<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi" id="pos_kecamatan">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_alamatusaha3" class="col-sm-2 col-form-label">Kode Pos<span class="wajib">*</span></label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control diisi" id="crm_alamatusaha3">
                                            </div>
                                            <label for="crm_alamatusaha2" class="col-sm-4 col-form-label">Kota<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi" id="crm_alamatusaha2">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_jenisusaha" class="col-sm-4 col-form-label">Apakah jenis Tempat Usaha Anda?<span class="wajib">*</span></label>
                                            <div class="col-sm-2">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input diisi_cb" id="cb_jenisbangunanP">
                                                    <label class="custom-control-label" for="cb_jenisbangunanP">Permanen</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input diisi_cb" id="cb_jenisbangunanS">
                                                    <label class="custom-control-label" for="cb_jenisbangunanS">Semi Permanen</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input diisi_cb" id="cb_jenisbangunanN">
                                                    <label class="custom-control-label" for="cb_jenisbangunanN">Non Permanen</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_lamatmpt" class="col-sm-2 col-form-label">Lama menempati<span class="wajib">*</span></label>
                                            <div class="col-sm-1">
                                                <input type="number" min="0" class="form-control diisi" id="crm_lamatmpt">
                                            </div>
                                            <label for="crm_lamatmpt" class="col-sm-1 pl-0 text-left col-form-label">Tahun</label>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_statusbangunan" class="col-sm-2 col-form-label">Status Bangunan<span class="wajib">*</span></label>
                                            <div class="col-sm-2">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input diisi_cb" id="cb_statusbangunanM">
                                                    <label class="custom-control-label" for="cb_statusbangunanM">Milik Sendiri</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input diisi_cb" id="cb_statusbangunanS">
                                                    <label class="custom-control-label" for="cb_statusbangunanS">Sewa</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_kreditusaha" class="col-sm-2 col-form-label">Kredit Usaha</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="crm_kreditusaha">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_bankkredit" class="col-sm-2 pl-0 col-form-label">Bank Penerima Kredit</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="crm_bankkredit">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_jeniskendaraan" class="col-sm-2 col-form-label">Jenis Kendaraan</label>
                                            <div class="col-sm-2">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input" id="cb_jeniskendaraanMotor">
                                                    <label class="custom-control-label" for="cb_jeniskendaraanMotor">Motor</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 pl-0 pr-0">
                                                <select class="browser-default custom-select" id="i_motor">
                                                    <option selected disabled>...</option>
                                                    <option value="HONDA">HONDA</option>
                                                    <option value="YAMAHA">YAMAHA</option>
                                                    <option value="KAWASAKI">KAWASAKI</option>
                                                    <option value="SUZUKI">SUZUKI</option>
                                                    <option value="X">LAINNYA</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3 pl-0">
                                                <input type="text" class="form-control" id="i_motorX">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_jeniskendaraan" class="col-sm-2 col-form-label">Jenis Kendaraan</label>
                                            <div class="col-sm-2">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input" id="cb_jeniskendaraanMobil">
                                                    <label class="custom-control-label" for="cb_jeniskendaraanMobil">Mobil</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 pl-0 pr-0">
                                                <select class="browser-default custom-select" id="i_mobil">
                                                    <option selected disabled>...</option>
                                                    <option value="TOYOTA">TOYOTA</option>
                                                    <option value="DAIHATSU">DAIHATSU</option>
                                                    <option value="MITSUBISHI">MITSUBISHI</option>
                                                    <option value="SUZUKI">SUZUKI</option>
                                                    <option value="HONDA">HONDA</option>
                                                    <option value="X">LAINNYA</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3 pl-0">
                                                <input type="text" class="form-control" id="i_mobilX">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="p_hobby" class="container tab-pane fade pl-0 pr-0 fix-height">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-10">
                                        <div class="card border-secondary">
                                            <div class="table-wrapper-scroll-y my-custom-scrollbar-hobby">
                                                <table id="table_hobby" class="table table-sm table-bordered">
                                                    <thead>
                                                    <tr class="d-flex text-center">
                                                        <th class="col-sm-5">Nama Hobby</th>
                                                        <th class="col-sm-1"></th>
                                                        <th class="col-sm-6">Keterangan</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php $i = 0 @endphp
                                                    @foreach($hobby as $h)
                                                    <tr class="row_hobby_{{ $i }} d-flex" id="{{ $h->hob_kodehobby }}">
                                                        <td class="col-sm-5"><label for="grp_group" class="col-sm-12 col-form-label">{{ $h->hob_namahobby }}</label></td>
                                                        <td class="col-sm-1">
                                                            <div class="custom-control custom-checkbox text-center">
                                                                <input onchange="check_hobby(event)" type="checkbox" class="custom-control-input" id="cb_h{{ $h->hob_kodehobby }}">
                                                                <label class="custom-control-label mt-2" for="cb_h{{ $h->hob_kodehobby }}"></label>
                                                            </div>
                                                        </td>
                                                        <td class="col-sm-6">
                                                            <input disabled type="text" class="form-control" id="cb_h{{ $h->hob_kodehobby }}_ket">
                                                        </td>
                                                    </tr>
                                                    @php $i++ @endphp
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>
                                </div>
                            </div>
                        </div>
                        <div id="p_alamatnpwp" class="container tab-pane fade pl-0 pr-0 fix-height">
                            <div class="card-body ">
                                <div class="row text-right">
                                    <div class="col-sm-12">
                                        <div class="form-group row mb-0">
                                            <label for="cus_tglmulai" class="col-sm-3 pl-0 col-form-label">Tanggal Mulai</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="cus_tglmulai"  placeholder="DD-MON-YYYY">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_tglregistrasi" class="col-sm-3 pl-0 col-form-label">Tanggal Registrasi</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="cus_tglregistrasi" placeholder="DD-MON-YYYY">
                                            </div>
                                            <label for="cus_flagbebasiuran" class="col-sm-4 pl-0 col-form-label">Bebas Iuran</label>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control" id="cus_flagbebasiuran">
                                            </div>
                                            <label for="cus_flagbebasiuran" class="col-sm-1 pl-0 text-left col-form-label">( Y /  )</label>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_alamatemail" class="col-sm-3 pl-0 col-form-label">Alamat Email</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="cus_alamatemail">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_nokartumember" class="col-sm-3 pl-0 col-form-label">Nomor Kartu</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="cus_nokartumember">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_flagblockingpengiriman" class="col-sm-3 pl-0 col-form-label">Blocking Pengiriman</label>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control" id="cus_flagblockingpengiriman">
                                            </div>
                                            <label for="cus_flagbebasiuran" class="col-sm-1 pl-0 text-left col-form-label">( Y /  )</label>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cus_flaginstitusipemerintah" class="col-sm-3 pl-0 col-form-label">Flag Institusi Pemerintah</label>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control" id="cus_flaginstitusipemerintah">
                                            </div>
                                            <label for="cus_flaginstitusipemerintah" class="col-sm-1 pl-0 text-left col-form-label">( Y /  )</label>
                                        </div>

                                        <fieldset class="card border-secondary">
                                            <div class="card-header pb-0">
                                                <h5 class="text-left">NPWP</h5>
                                            </div>
                                            <div class="card-body ">
                                                <div class="row text-right">
                                                    <div class="col-sm-12">
                                                        <div class="form-group row mb-0">
                                                            <label for="i_alamatnpwp" class="col-sm-3 pl-0 col-form-label">Alamat</label>
                                                            <div class="col-sm-8 pl-0">
                                                                <input type="text" class="form-control" id="i_alamatnpwp">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="i_kelurahannpwp" class="col-sm-3 pl-0 col-form-label">Kelurahan</label>
                                                            <div class="col-sm-3 pl-0">
                                                                <input type="text" class="form-control" id="i_kelurahannpwp">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="i_kotanpwp" class="col-sm-3 pl-0 col-form-label">Kota</label>
                                                            <div class="col-sm-3 pl-0">
                                                                <input type="text" class="form-control" id="i_kotanpwp">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="i_kodeposnpwp" class="col-sm-3 pl-0 col-form-label">Kode Pos</label>
                                                            <div class="col-sm-2 pl-0">
                                                                <input type="text" class="form-control" id="i_kodeposnpwp">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="p_fasilitasbank" class="container tab-pane fade pl-0 pr-0 fix-height">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-6">
                                        <div class="card border-secondary">
                                            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                                <table id="table_fasilitas_perbankan" class="table table-sm table-bordered mb-0">
                                                    <thead>
                                                    </thead>
                                                    <tbody>
                                                    @php $i = 0; @endphp
                                                    @foreach($fasilitasperbankan as $fp)
                                                    <tr class="row_fasilitasperbankan_{{ $i }} d-flex" id="{{ $fp->fba_kodefasilitasbank }}">
                                                        <td class="col-sm-1">
                                                            <div class="custom-control custom-checkbox text-center">
                                                                <input type="checkbox" class="custom-control-input" id="cb_b{{ $fp->fba_kodefasilitasbank }}">
                                                                <label class="custom-control-label ml-1" for="cb_b{{ $fp->fba_kodefasilitasbank }}"></label>
                                                            </div>
                                                        </td>
                                                        <td class="col-sm-11">{{ $fp->fba_namafasilitasbank }}</td>
                                                    </tr>
                                                    @php $i++; @endphp
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row text-right">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="i_updateterakhir" class="col-sm-2 col-form-label">Update Terakhir</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="i_updateterakhir">
                                    </div>
                                    <label for="i_harusdiisi" class="col-sm-3 text-right"><span class="wajib">*Harus diisi</span></label>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-sm-2 offset-sm-2">
                                        <button id="btn-rekam" class="btn btn-primary btn-block" disabled>REKAM</button>
                                    </div>
                                    <div class="col-sm-2 pl-0">
                                        <button id="btn-aktif-nonaktif" class="btn btn-primary btn-block" disabled>AKTIF / NONAKTIF</button>
                                    </div>
                                    <div class="col-sm-2 pl-0">
                                        <button id="btn-hapus" class="btn btn-danger btn-block" disabled>HAPUS</button>
                                    </div>
                                    <div class="col-sm-2 pl-0">
                                        <button id="btn-quisioner" class="btn btn-info btn-block" style="display:none">QUISIONER</button>
                                    </div>
                                    <div class="col-sm-2">
                                        <button id="btn-export-crm" class="btn btn-success btn-block" disabled>EXPORT KE CRM</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="m_kodememberHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Master Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_member">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Nama Member</th>
                                        <th>Kode Member</th>
                                    </tr>
                                    </thead>
                                    <tbody>
{{--                                    @foreach($member as $m)--}}
{{--                                        <tr onclick="lov_member_select('{{ $m->cus_kodemember }}',true)" class="row_lov">--}}
{{--                                            <td>{{ $m->cus_namamember }}</td>--}}
{{--                                            <td>{{ $m->cus_kodemember }}</td>--}}
{{--                                        </tr>--}}
{{--                                    @endforeach--}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_kodeposHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Master Kode POS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_kodepos">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kelurahan</th>
                                        <th>Kecamatan</th>
                                        <th>Kota</th>
                                        <th>Provinsi</th>
                                        <th>Kode Pos</th>
                                    </tr>
                                    </thead>
                                    <tbody>
{{--                                    @foreach($kodepos as $k)--}}
{{--                                        <tr onclick="lov_kodepos_select('{{ $k->pos_kode }}','{{ $k->pos_kecamatan }}','{{ $k->pos_kelurahan }}','{{ $k->pos_kabupaten }}')" class="row_lov">--}}
{{--                                            <td>{{ $k->pos_kelurahan }}</td>--}}
{{--                                            <td>{{ $k->pos_kecamatan }}</td>--}}
{{--                                            <td>{{ $k->pos_kabupaten }}</td>--}}
{{--                                            <td>{{ $k->pos_propinsi }}</td>--}}
{{--                                            <td>{{ $k->pos_kode }}</td>--}}
{{--                                        </tr>--}}
{{--                                    @endforeach--}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_jenismemberHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Master Jenis Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_jenismember">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Keterangan</th>
                                        <th>Kode</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($jenismember as $jm)
                                        <tr onclick="lov_jenismember_select('{{ $jm->jm_kode }}','{{ $jm->jm_keterangan }}')" class="row_lov">
                                            <td>{{ $jm->jm_keterangan }}</td>
                                            <td>{{ $jm->jm_kode }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_jenisoutletHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Master Jenis Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_jenisoutlet">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($jenisoutlet as $jo)
                                        <tr onclick="lov_jenisoutlet_select('{{ $jo->out_kodeoutlet }}','{{ $jo->out_namaoutlet }}')" class="row_lov">
                                            <td>{{ $jo->out_kodeoutlet }}</td>
                                            <td>{{ $jo->out_namaoutlet }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_groupHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_group">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Group</th>
                                        <th>Subgroup</th>
                                        <th>Kategori</th>
                                        <th>Subkategori</th>
                                        <th>ID Group</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($group as $g)
                                        <tr onclick="lov_group_select('{{ $g->grp_idgroupkat }}')" class="row_lov">
                                            <td>{{ $g->grp_group }}</td>
                                            <td>{{ $g->grp_subgroup }}</td>
                                            <td>{{ $g->grp_kategori }}</td>
                                            <td>{{ $g->grp_subkategori }}</td>
                                            <td>{{ $g->grp_idgroupkat }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_quisioner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <fieldset class="card border-secondary">
                                    <legend  class="w-auto ml-3">Quisioner Member Khusus</legend>
                                    <div class="card-body">
                                        <div class="row text-right">
                                            <form>
                                            <div class="col-sm-12">
                                                <div class="form-group row mb-0">
                                                    <label for="q_kodemember" class="col-sm-3 col-form-label">Kode Member</label>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" id="q_kodemember">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="q_namamember" class="col-sm-3 col-form-label wajib">Nama Member</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="q_namamember">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="table-wrapper-scroll-y my-custom-scrollbar-hobby mb-2">
                                                <table class="table table-sm mb-0" id="table_quisioner">
                                                    <thead>
                                                    <tr>
                                                        <td>Item</td>
                                                        <td>Dijual</td>
                                                        <td>Beli di IGR</td>
                                                        <td>Beli Tempat Lain</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($produkmember as $pm)
                                                        <tr class="row_quisioner" id="q_{{ $pm->mpm_kodeprdcd }}">
                                                            <td>{{ $pm->mpm_namaprdcd }}</td>
                                                            <td>
                                                                <input type="text" maxlength="1" pattern="[Y|N]" class="quisioner dijual form-control">
                                                            </td>
                                                            <td>
                                                                <input type="text" maxlength="1" class="quisioner beli-igr form-control">
                                                            </td>
                                                            <td>
                                                                <input type="text" maxlength="1" class="quisioner beli-lain form-control">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group row mb-0">
                                                    <div class="col-sm-5 text-left">
                                                        <label>Inputan Quisioner : [ Y / blank ]</label>
                                                    </div>
                                                    <div class="col-sm-5"></div>
                                                    <div class="col-sm-1">
                                                        <button type="submit" id="btn-q-save" class="btn btn-primary">SAVE</button>
                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_aktifnonaktif" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="form-group row text-center">
                            <label for="i_username" class="col-sm-12 text-center col-form-label">Masukkan username dan password untuk melanjutkan</label>
                        </div>
                        <div class="form-group row text-center">
                            <div class="col-sm-2"></div>
                            <label for="i_username" class="col-sm-2 pl-0 col-form-label">Username</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="i_username">
                            </div>
                            <div class="col-sm-2"></div>
                        </div>
                        <div class="form-group row text-center">
                            <div class="col-sm-2"></div>
                            <label for="i_password" class="col-sm-2 pl-0 col-form-label">Password</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" id="i_password">
                            </div>
                            <div class="col-sm-2"></div>
                        </div>
                        <div class="form-group row text-center">
                            <div class="col-sm-4"></div>
                            <button id="btn-aktifnonaktif-ok" class="btn col-sm-4 btn-info">OK</button>
                            <div class="col-sm-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <style>
        /*.row_lov:hover{*/
        /*    cursor: pointer;*/
        /*    background-color: grey;*/
        /*    color: white;*/
        /*}*/

        .my-custom-scrollbar-hobby {
            position: relative;
            height: 650px;
            overflow: auto;
        }

        .my-custom-scrollbar {
            position: relative;
            height: 380px;
            overflow: auto;
        }
        .table-wrapper-scroll-y {
            display: block;
        }

        .custom-color li a{
            background-color: lightgrey;
        }

        .fix-height{
            height: 672px;
        }

        .wajib{
            color: red;
        }

        input{
            text-transform: uppercase;
        }


        input.tanggal {
            position: relative;
        }

        input.tanggal:before {
            position: absolute;
            top: 3px; left: 3px;
            content: attr(data-date);
            display: inline-block;
            color: black;
        }

        input.tanggal::-webkit-datetime-edit, input::-webkit-inner-spin-button, input::-webkit-clear-button {
            display: none;
        }

        input.tanggal::-webkit-calendar-picker-indicator {
            position: absolute;
            top: 3px;
            right: 0;
            color: black;
            opacity: 1;
        }

        .kosong{
            border-radius: 3px !important;
            outline: none !important;
            border-color: red !important;
            box-shadow: 0 0 10px red !important;
        }

        .segment{
            background-color: lightgrey;
        }

        .segment label{
            font-weight: bold !important;
            color: red !important;
        }

        .table-wrapper{
            overflow-y: scroll;
        }

    </style>

    <script>

        $(document).ready(function () {
            getLovMember();
            getLovKodepos();
            $('#table_lov_jenismember').DataTable();
            $('#table_lov_jenisoutlet').DataTable();
            $('#table_lov_group').DataTable();
        });

        function getLovMember(){
            $('#table_lov_member').DataTable({
                "ajax": '{{ url('mstmember/getlovmember') }}',
                "columns": [
                    {data: 'cus_namamember', name: 'cus_namamember', width : '60%'},
                    {data: 'cus_kodemember', name: 'cus_kodemember', width : '40%'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('lov_member_select row_lov');
                },
                "order": [],
                columnDefs : [
                ]
            });
        }

        $(document).on('click', '.lov_member_select', function () {
            let member = $(this).find('td')[1]['innerHTML']

            lov_member_select(member, true)
        } );

        function getLovKodepos(){
            $('#table_lov_kodepos').DataTable({
                "ajax": '{{ url('mstmember/getlovkodepos') }}',
                "columns": [
                    {data: 'pos_kelurahan', name: 'pos_kelurahan'},
                    {data: 'pos_kecamatan', name: 'pos_kecamatan'},
                    {data: 'pos_kabupaten', name: 'pos_kabupaten'},
                    {data: 'pos_propinsi', name: 'pos_propinsi'},
                    {data: 'pos_kode', name: 'pos_kode'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('lov_kodepos_select row_lov');
                },
                "order": [],
                columnDefs : [
                ]
            });
        }

        $(document).on('click', '.lov_kodepos_select', function () {
            let member = $(this).find('td')[1]['innerHTML']

            let pos_kode = $(this).find('td')[4]['innerHTML'];
            let pos_kecamatan = $(this).find('td')[1]['innerHTML'];
            let pos_kelurahan = $(this).find('td')[0]['innerHTML'];
            let pos_kabupaten = $(this).find('td')[2]['innerHTML'];

            lov_kodepos_select(pos_kode,pos_kecamatan,pos_kelurahan,pos_kabupaten);
        } );

        // lov_member_select('1',false);

        month = ['JAN','FEB','MAR','APR','MEI','JUN','JUL','AGU','SEP','OKT','NOV','DES'];
        trlovmember = $('#table_lov_member tbody').html();
        trlovkodepos = $('#table_lov_kodepos tbody').html();
        field = 'ktp';

        arrjenismember = @php echo($jenismember); @endphp;
        arrjenisoutlet = @php echo($jenisoutlet); @endphp;
        arrgroup = @php echo($group); @endphp;
        arrhobby = @php echo($hobby); @endphp;
        arrbank = @php echo($fasilitasperbankan); @endphp;
        quisioner = '';

        member = '';
        idgroupkat = '';

        lov_member_select(1,false);


        $('#i_pendidikanX').hide();
        $('#c_metodekirimX').hide();
        $('#i_motor').hide();
        $('#i_motorX').hide();
        $('#i_mobil').hide();
        $('#i_mobilX').hide();

        // $('#btn-quisioner').hide();
        // $('#m_quisioner').modal('toggle');

        // $('#btn-p_identitas2').click();

        $(':input').on('keyup',function(){
            $(this).val(this.value.toUpperCase());
        });

        $('.diisi').on('change',function(){
            if($(this).val() == null){
                ok = false;
                $(this).addClass('kosong');
            }
            else if($(this).val().length == 0){
                ok = false;
                $(this).addClass('kosong');
            }
            else{
                $(this).removeClass('kosong');
            }
        });

        $(':input').prop('disabled',true);



        // $('#btn-rekam').prop('disabled',true);
        // $('#btn-aktif-nonaktif').prop('disabled',true);
        // $('#btn-hapus').prop('disabled',true);
        // $('#btn-export-crm').prop('disabled',true);

        $(':input').on('click',function(){
            $(this).select();
        });

        initial();

        //----------------------MULAI-------------------

        $('#cus_kodemember').on('keypress blur',function (event) {
            if(event.which == 13) {
                if(this.value.length == 0) {
                    swal({
                        title: "Isikan Nomor Anggota terlebih dahulu!",
                        icon: "error",
                        timer: 750,
                        buttons: false,
                    }).then(function () {
                        swal.close();
                        $(':input').val('');
                        $(':input').prop('checked', false);
                    });
                }
                else{
                    lov_member_select(this.value);
                }
            }
        });

        $('#cus_namamember').on('keypress',function(event){
            if(event.which == 13){
                if(this.value.length > 0){
                    $('#cus_noktp').select();
                }
            }
        });

        $('#cus_noktp').on('keypress',function(event){
            if(event.which == 13){
                if(this.value.length > 0){
                    $('#cus_alamatmember1').select();
                }
            }
        });

        $('#cus_alamatmember1').on('keypress',function(event){
            if(event.which == 13){
                if(this.value.length > 0){
                    $('#cus_alamatmember4').select();
                }
            }
        });

        $('#cus_alamatmember4').on('keypress',function(event){
            if(event.which == 13){
                if(this.value.length > 0){
                    field = 'ktp';
                    lov_kodepos_select('x','x',this.value.toUpperCase(),'x');
                }
            }
        });

        $('#cus_alamatmember4').on('blur',function(event){
            if(this.value.length > 0){
                field = 'ktp';
                lov_kodepos_select('x','x',this.value.toUpperCase(),'x');
            }
        });

        $('#cus_alamatmember5').on('keypress',function(event){
            if(event.which == 13){
                if(this.value.length > 0){
                    $('#cus_alamatmember8').select();
                }
            }
        });

        $('#cus_alamatmember8').on('keypress',function(event){
            if(event.which == 13){
                if(this.value.length > 0){
                    field = 'surat';
                    lov_kodepos_select('x','x',this.value.toUpperCase(),'x');
                }
            }
        });

        $('#cus_alamatmember8').on('blur',function(event){
            if(this.value.length > 0){
                field = 'surat';
                lov_kodepos_select('x','x',this.value.toUpperCase(),'x');
            }
        });

        $('#cus_tlpmember').on('keypress',function(event){
            if(event.which == 13){
                if(this.value.length > 0){
                    $('#cus_hpmember').select();
                }
            }
        });

        $('#cus_hpmember').on('keypress',function(event){
            if(event.which == 13){
                if(this.value.length > 0){
                    $('#crm_tmptlahir').select();
                }
            }
        });

        $('#crm_tmptlahir').on('keypress',function(event){
            if(event.which == 13){
                if(this.value.length > 0){
                    $('#cus_tgllahir').select();
                }
            }
        });

        $('#cus_tgllahir').on('change',function(){
            $('#cus_jenismember').select();
        });

        $('#cus_jenismember').on('keypress',function(event){
            if(event.which == 13){
                found = false;
                if(this.value == ''){
                    $('#cus_jenismember').val(arrjenismember[0].jm_kode);
                    $('#i_jeniscustomer2').val(arrjenismember[0].jm_keterangan);
                    $('#cus_kodeoutlet').select();
                    found = true;
                }
                else{
                    for(i=0;i<arrjenismember.length;i++){
                        if(this.value == arrjenismember[i].jm_kode){
                            found = true;
                            $('#cus_jenismember').val(arrjenismember[i].jm_kode);
                            $('#i_jeniscustomer2').val(arrjenismember[i].jm_keterangan);
                            $('#cus_kodeoutlet').select();
                            break;
                        }
                    }
                }
                if(!found){
                    swal({
                        title: "Jenis Member Tidak Ditemukan",
                        icon: "error"
                    }).then(function(){
                        swal.close();
                        $('#cus_jenismember').select();
                    });
                }
                else{
                    $('#cus_kodeoutlet').select();
                }
            }
        });

        $('#cus_kodeoutlet').on('keypress',function(event){
            if(event.which == 13){
                found = false;

                for(i=0;i<arrjenisoutlet.length;i++){
                    if(this.value == arrjenisoutlet[i].out_kodeoutlet){
                        found = true;
                        $('#cus_kodeoutlet').val(arrjenisoutlet[i].out_kodeoutlet);
                        $('#i_jenisoutlet2').val(arrjenisoutlet[i].out_namaoutlet);
                        $('#cus_jarak').select();
                        break;
                    }
                }
                if(!found){
                    swal({
                        title: "Jenis Outlet Tidak Ditemukan",
                        icon: "error",
                        closeModal: false
                    }).then(function(){
                        swal.close();
                        $('#cus_kodeoutlet').select();
                    });
                }
                else{
                    $('#cus_jarak').select();
                }
            }
        });

        $('#cus_jarak').on('keypress',function(event){
            if(event.which == 13){
                $('#cus_flagpkp').select();
            }
        });

        $('#cus_flagpkp').on('keypress', function(event){
            if(event.which == 13){
                this.value = this.value.toUpperCase();
                if(this.value != 'Y' && this.value != 'T' && this.value != ''){
                    swal({
                        title: "Pastikan inputan hanya berupa Y atau T",
                        icon: "error",
                        closeModal: false
                    }).then(function(){
                        swal.close();
                        $('#cus_flagpkp').select();
                    });
                }
                else{
                    $('#cus_npwp').select();
                }
            }
        });

        $('#cus_npwp').on('keypress',function(event){
            if(event.which == 13){
                $('#cus_flagkredit').select();
            }
        });

        $('#cus_flagkredit').on('keypress', function(event){
            if(event.which == 13){
                this.value = this.value.toUpperCase();
                if(this.value != 'Y' && this.value != 'T' && this.value != ''){
                    swal({
                        title: "Pastikan inputan hanya berupa Y atau T!",
                        icon: "error",
                        closeModal: false
                    }).then(function(){
                        swal.close();
                        $('#cus_flagkredit').select();
                    });
                }
                else{
                    $('#cus_creditlimit').select();
                }
            }
        });

        $('#cus_creditlimit').on('keypress',function(event){
            if(event.which == 13){
                if(this.value < 0){
                    swal({
                        title: "Pastikan nilai limit tidak kurang dari nol!",
                        icon: "error",
                        closeModal: false
                    }).then(function(){
                        swal.close();
                        $('#cus_creditlimit').select();
                    });
                }
                else{
                    $('#cus_top').select();
                }
            }
        });

        $('#cus_top').on('keypress',function(event){
            if(event.which == 13){
                if(this.value < 0){
                    swal({
                        title: "Pastikan nilai TOP tidak kurang dari nol!",
                        icon: "error",
                        closeModal: false
                    }).then(function(){
                        swal.close();
                        $('#cus_creditlimit').select();
                    });
                }
                else{
                    $('#cus_nosalesman').select();
                }
            }
        });

        $('#cus_nosalesman').on('keypress',function(event){
            if(event.which == 13){

                $('#cus_flagmemberkhusus').select();
            }
        });

        $('#cus_flagmemberkhusus').on('keypress',function(event){
            if(event.which == 13){

                $('#cus_flagkirimsms').select();
            }
        });

        $('#cus_flagkirimsms').on('keypress',function(event){
            if(event.which == 13){

                $('#btn-p_identitas2').click();
                $('#grp_group').select();
            }
        });

        $('#grp_group').on('keypress',function(event){
            if(event.which == 13 ){
                if(this.value == ''){
                    $('#m_groupHelp').modal('toggle');
                }
                else{
                    if($('#cus_flagmemberkhusus').val() != 'Y' && this.value != 'BIRU'){
                        swal({
                            title: "Group harus diisi BIRU karena bukan member khusus",
                            icon: "error",
                            closeModal: false
                        }).then(function(){
                            swal.close();
                            $('#grp_group').select();
                            $('#grp_group').val('');
                            $('#grp_subgroup').val('');
                            $('#grp_kategori').val('');
                            $('#grp_subkategori').val('');
                        });
                    }
                    else{
                        lov_group_select($(this).val());
                    }
                }
            }
        });

        $('#cb_jenisanggotaR').on('keydown',function(event){
            if(event.which == 13){
                $(this).click();
                $('#cb_jeniskelaminL').focus();
            }
            else if(event.which == 39){
                $('#cb_jenisanggotaK').focus();
            }
        });

        $('#cb_jenisanggotaK').on('keydown',function(event){
            if(event.which == 13){
                $(this).click();
                $('#cb_jeniskelaminL').focus();
            }
            else if(event.which == 37){
                $('#cb_jenisanggotaR').focus();
            }
        });

        $('#cb_jenisanggotaR').on('change',function(){
            if($('#cb_jenisanggotaR').is(':checked')){
                $('#cb_jenisanggotaK').prop('checked',false);
            }
        });

        $('#cb_jenisanggotaK').on('change',function(){
            if($('#cb_jenisanggotaK').is(':checked')){
                $('#cb_jenisanggotaR').prop('checked',false);
            }
        });

        $('#cb_jeniskelaminL').on('keydown',function(event){
            if(event.which == 13){
                $('#cb_jeniskelaminL').click();
                $('#crm_pic1').select();
            }
            else if(event.which == 39){
                $('#cb_jeniskelaminP').focus();
            }
        });

        $('#cb_jeniskelaminP').on('keydown',function(event){
            event.preventDefault();
            if(event.which == 13){
                $('#cb_jeniskelaminP').click();
                $('#crm_pic1').select();
            }
            else if(event.which == 37){
                $('#cb_jeniskelaminL').focus();
            }
        });

        $('#cb_jeniskelaminL').on('change',function(){
            if($('#cb_jeniskelaminL').is(':checked')){
                $('#cb_jeniskelaminP').prop('checked',false);
            }
        });

        $('#cb_jeniskelaminP').on('change',function(){
            if($('#cb_jeniskelaminP').is(':checked')){
                $('#cb_jeniskelaminL').prop('checked',false);
            }
        });

        $('#crm_pic1').on('keydown',function(event){
            if(event.which == 13){
                // if(this.value.length > 0){
                //     $('#crm_nohppic1').prop('disabled',false);
                //     $('#crm_nohppic1').select();
                // }
                // else{
                //     $('#crm_nohppic1').prop('disabled',true);
                //
                // }
                $('#crm_pic2').select();
            }
        });

        $('#crm_pic1').on('blur',function(){
            if($(this).val().length == 0){
                $('#crm_nohppic1').val('');
                $('#crm_nohppic1').prop('disabled',true);
            }
            else{
                $('#crm_nohppic1').prop('disabled',false);
            }
        });

        $('#crm_nohppic1').on('keydown',function(event){
            if(event.which == 13){
                $('#crm_pic2').select();
            }
        });

        $('#crm_pic2').on('keydown',function(event){
            if(event.which == 13){
                if(this.value.length > 0){
                    $('#crm_nohppic2').prop('disabled',false);
                    $('#crm_nohppic2').select();
                }
                else{
                    $('#crm_nohppic2').prop('disabled',true);
                    $('#crm_email').select();
                }
            }
        });

        $('#crm_pic2').on('blur',function(){
            if($(this).val().length == 0){
                $('#crm_nohppic2').val('');
                $('#crm_nohppic2').prop('disabled',true);
            }
            else{
                $('#crm_nohppic2').prop('disabled',false);
            }
        });

        $('#crm_nohppic2').on('keydown',function(event){
            if(event.which == 13){
                $('#crm_email').select();
            }
        });

        $('#crm_email').on('keydown',function(event){
            if(event.which == 13 && this.value.length > 0){
                $('#crm_agama').focus();
            }
        });

        $('#crm_agama').on('keydown',function(event){
            if(event.which == 13 && this.value != null){
                $('#crm_pekerjaan').focus();
            }
            else{
                swal({
                    title: "Agama harus diisi!",
                    icon: "error",
                    closeModal: false
                }).then(function(){
                    swal.close();
                    $('#crm_agama').select();
                });
            }
        });

        $('#crm_pekerjaan').on('keydown',function(event){
            if(event.which == 13){
                $('#crm_namapasangan').select();
            }
        });

        $('#crm_namapasangan').on('keydown',function(event){
            if(event.which == 13){
                $('#crm_tgllhrpasangan').select();
            }
        });

        $('#crm_tgllhrpasangan').on('keydown',function(event){
            if(event.which == 13){
                if(this.value.length > 0){
                    found = cek_format_tanggal(this.value);

                    if(!found){
                        swal({
                            title: "Format Tanggal Salah",
                            icon: "error",
                            closeModal: false
                        }).then(function(){
                            swal.close();
                            $('#crm_tgllhrpasangan').select();
                        });
                    }
                    else{
                        $('#crm_jmlanak').select();
                    }
                }
                else{
                    $('#crm_jmlanak').select();
                }
            }
        });

        $('#crm_jmlanak').on('keydown',function(event){
            if(event.which == 13){
                if(this.value.length > 0  && this.value < 0){
                    swal({
                        title: "Jumlah anak tidak boleh kurang dari nol!",
                        icon: "error",
                        closeModal: false
                    }).then(function(){
                        swal.close();
                        $('#crm_jmlanak').select();
                    });
                }
                else{
                    $('#i_pendidikan').focus();
                }
            }
        });

        $('#i_pendidikan').on('keydown',function(event){
            if(event.which == 13){
                $('#crm_nofax').select();
            }
        });

        $('#i_pendidikan').on('change',function(){
            if(this.value == 'X'){
                $('#i_pendidikanX').val('');
                $('#i_pendidikanX').show();
            }
            else{
                $('#i_pendidikanX').val('');
                $('#i_pendidikanX').hide();
            }
        });

        $('#crm_nofax').on('keydown',function(event){
            if(event.which == 13){
                $('#cb_internetY').focus();
            }
        });

        $('#cb_internetY').on('keydown',function(event){
            if(event.which == 13){
                $(this).click();
                $('#cb_internetT').prop('checked',false);
                $('#crm_tipehp').focus();
            }
            else if(event.which == 39){
                $('#cb_internetT').focus();
            }
        });

        $('#cb_internetT').on('keydown',function(event){
            if(event.which == 13){
                $(this).click();
                $('#cb_internetY').prop('checked',false);
                $('#crm_tipehp').focus();
            }
            else if(event.which == 37){
                $('#cb_internetY').focus();
            }
        });

        $('#crm_tipehp').on('keydown',function(event){
            if(event.which == 13){
                $('#crm_namabank').select();
            }
        });

        $('#crm_namabank').on('keydown',function(event){
            if(event.which == 13 && this.value.length > 0){
                $('#c_metodekirim').focus();
            }
        });

        $('#c_metodekirim').on('keydown',function(event){
            if(event.which == 13 && this.value != null){
                if(this.value == 'X'){
                    $('#c_metodekirimX').focus();
                }
                else{
                    $('#i_koordinat').focus();
                }
            }
        });

        $('#c_metodekirim').on('change',function(){
            if(this.value == 'X'){
                $('#c_metodekirimX').val('');
                $('#c_metodekirimX').show();
            }
            else{
                $('#c_metodekirimX').val('');
                $('#c_metodekirimX').hide();
            }
        });

        $('#c_metodekirimX').on('keydown',function(event){
            if(event.which == 13 && this.value != ''){
                $('#i_koordinat').select();
            }
        });

        $('#i_koordinat').on('keydown',function(event){
            if(event.which == 13){
                $('#btn-p_identitas3').click();
            }
        });

        $('#crm_alamatusaha1').on('keypress',function(event){
            if(event.which == 13 && this.value.length > 0){
                $('#crm_alamatusaha4').select();
            }
        });

        $('#crm_alamatusaha4').on('keypress',function(event){
            if(event.which == 13){
                if(this.value.length > 0){
                    field = 'usaha';
                    lov_kodepos_select('x','x',this.value.toUpperCase(),'x');
                }
            }
        });

        $('#crm_alamatusaha4').on('blur',function(event){
            if(this.value.length > 0){
                field = 'usaha';
                lov_kodepos_select('x','x',this.value.toUpperCase(),'x');
            }
        });

        $('#cb_jenisbangunanP').on('keydown',function(event){
            if(event.which == 13){
                $(this).click();
                $('#cb_jenisbangunanS').prop('checked',false);
                $('#cb_jenisbangunanN').prop('checked',false);
                $('#crm_lamatmpt').select();
            }
            else if(event.which == 39){
                $('#cb_jenisbangunanS').focus();
            }
        });

        $('#cb_jenisbangunanS').on('keydown',function(event){
            if(event.which == 13){
                $(this).click();
                $('#cb_jenisbangunanP').prop('checked',false);
                $('#cb_jenisbangunanN').prop('checked',false);
                $('#crm_lamatmpt').select();
            }
            else if(event.which == 37){
                $('#cb_jenisbangunanP').focus();
            }
            else if(event.which == 39){
                $('#cb_jenisbangunanN').focus();
            }
        });

        $('#cb_jenisbangunanN').on('keydown',function(event){
            if(event.which == 13){
                $(this).click();
                $('#cb_jenisbangunanP').prop('checked',false);
                $('#cb_jenisbangunanS').prop('checked',false);
                $('#crm_lamatmpt').select();
            }
            else if(event.which == 37){
                $('#cb_jenisbangunanS').focus();
            }
        });

        $('#cb_jenisbangunanP').on('change',function () {
            if($('#cb_jenisbangunanP').is(':checked')){
                $('#cb_jenisbangunanS').prop('checked',false);
                $('#cb_jenisbangunanN').prop('checked',false);
            }
        });

        $('#cb_jenisbangunanS').on('change',function () {
            if($('#cb_jenisbangunanS').is(':checked')){
                $('#cb_jenisbangunanP').prop('checked',false);
                $('#cb_jenisbangunanN').prop('checked',false);
            }
        });

        $('#cb_jenisbangunanN').on('change',function () {
            if($('#cb_jenisbangunanN').is(':checked')){
                $('#cb_jenisbangunanP').prop('checked',false);
                $('#cb_jenisbangunanS').prop('checked',false);
            }
        });

        $('#crm_lamatmpt').on('keydown',function(event){
            if(event.which == 13 && this.value >= 0){
                $('#cb_statusbangunanM').focus();
            }
        });

        $('#cb_statusbangunanM').on('keydown',function(event){
            if(event.which == 13){
                $(this).click();
                $('#cb_statusbangunanS').prop('checked',false);
                $('#crm_kreditusaha').select();
            }
            else if(event.which == 39){
                $('#cb_statusbangunanS').focus();
            }
        });

        $('#cb_statusbangunanS').on('keydown',function(event){
            if(event.which == 13){
                $(this).click();
                $('#cb_statusbangunanM').prop('checked',false);
                $('#crm_kreditusaha').select();
            }
            else if(event.which == 37){
                $('#cb_statusbangunanM').focus();
            }
        });

        $('#cb_statusbangunanM').on('change',function () {
            if($('#cb_statusbangunanM').is(':checked')){
                $('#cb_statusbangunanS').prop('checked',false);
            }
        });

        $('#cb_statusbangunanS').on('change',function () {
            if($('#cb_statusbangunanS').is(':checked')){
                $('#cb_statusbangunanM').prop('checked',false);
            }
        });

        $('#crm_kreditusaha').on('keydown',function(event){
            if(event.which == 13){
                $('#crm_bankkredit').select();
            }
        });

        $('#crm_bankkredit').on('keydown',function(event){
            if(event.which == 13){
                $('#cb_jeniskendaraanMotor').focus();
            }
        });

        $('#cb_jeniskendaraanMotor').on('change',function () {
            if($('#cb_jeniskendaraanMotor').is(':checked')){
                $('#i_motor').val('...');
                $('#i_motor').show();
                $('#i_motor').focus();
            }
            else{
                $('#i_motor').val('...');
                $('#i_motor').hide();
                $('#i_motorX').val('');
                $('#i_motorX').hide();
            }
        });

        $('#cb_jeniskendaraanMotor').on('keydown',function (event) {
            if(event.which == 13){
                $('#cb_jeniskendaraanMobil').focus();
            }
        });

        $('#i_motor').on('change',function () {
            if(this.value == 'X'){
                $('#i_motorX').val('');
                $('#i_motorX').show();
            }
            else{
                $('#i_motorX').val('');
                $('#i_motorX').hide();
            }
        });

        $('#i_motor').on('keypress',function(event){
            event.preventDefault();
            if(event.which == 13){
                $('#cb_jeniskendaraanMobil').focus();
            }
        });

        $('#i_motorX').on('keypress',function(event){
            if(event.which == 13 && this.value.length > 0){
                $('#cb_jeniskendaraanMobil').focus();
            }
        });

        $('#cb_jeniskendaraanMobil').on('change',function () {
            if($('#cb_jeniskendaraanMobil').is(':checked')){
                $('#i_mobil').val('...');
                $('#i_mobil').show();
                $('#i_mobil').focus();
            }
            else{
                $('#i_mobil').val('...');
                $('#i_mobil').hide();
                $('#i_mobilX').val('');
                $('#i_mobilX').hide();
            }
        });

        $('#cb_jeniskendaraanMobil').on('keydown',function(event){
            if(event.which == 13){
                $('#btn-p_hobby').click();
            }
        });

        $('#i_mobil').on('change',function () {
            if(this.value == 'X'){
                $('#i_mobilX').val('');
                $('#i_mobilX').show();
                $('#i_mobilX').focus();
            }
            else{
                $('#i_mobilX').val('');
                $('#i_mobilX').hide();
            }
        });

        $('#i_mobil').on('keypress',function(event){
            event.preventDefault();
            if(event.which == 13){
                $('#btn-p_hobby').click();
            }
        });

        $('#i_mobilX').on('keypress',function(event){
            if(event.which == 13 && this.value.length > 0){
                $('#btn-p_hobby').click();
            }
        });

        $('#btn-p_npwp').on('click',function(){
            $('#cus_flagbebasiuran').select();
        });

        $('#cus_flagbebasiuran').on('keypress',function(event){
            if(event.which == 13){
                if(this.value != 'Y' && this.value != ''){
                    swal({
                        title: "Pastikan inputan hanya berupa Y atau kosong",
                        icon: "error",
                        closeModal: false
                    }).then(function(){
                        swal.close();
                        $('#cus_flagbebasiuran').select();
                    });
                }
                else{
                    $('#cus_alamatemail').select();
                }
            }
        });

        $('#cus_alamatemail').on('keypress',function(event){
            if(event.which == 13){
                $('#cus_flagblockingpengiriman').select();
            }
        });

        $('#cus_flagblockingpengiriman').on('keypress',function(event){
            if(event.which == 13){
                if(this.value != 'Y' && this.value != ''){
                    swal({
                        title: "Pastikan inputan hanya berupa Y atau kosong",
                        icon: "error",
                        closeModal: false
                    }).then(function(){
                        swal.close();
                        $('#cus_flagblockingpengiriman').select();
                    });
                }
                else{
                    $('#cus_flaginstitusipemerintah').select();
                }
            }
        });

        $('#cus_flaginstitusipemerintah').on('keypress',function(event){
            if(event.which == 13){
                if(this.value != 'Y' && this.value != ''){
                    swal({
                        title: "Pastikan inputan hanya berupa Y atau kosong",
                        icon: "error",
                        closeModal: false
                    }).then(function(){
                        swal.close();
                        $('#cus_flaginstitusipemerintah').select();
                    });
                }
                else{
                    $('#btn-p_fasilitasbank').click();
                }
            }
        });

        $('#search_lov_member').keypress(function (e) {
            if (e.which == 13) {
                if(this.value.length == 0) {
                    $('.invalid-feedback').hide();
                    $('#table_lov_member .not-found').remove();
                    $('#table_lov_member .row_lov').remove();
                    $('#table_lov_member').append(trlovmember);
                }
                else if(this.value.length >= 4) {
                    $('.invalid-feedback').hide();
                    $.ajax({
                        url: '/BackOffice/public/mstmember/lov_member_search',
                        type: 'GET',
                        data: {"_token": "{{ csrf_token() }}", value: this.value.toUpperCase()},
                        beforeSend: function(){
                            $('#m_kodememberHelp').modal({backdrop: 'static', keyboard: false});
                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        },
                        success: function (response) {
                            $('#table_lov_member .row_lov').remove();
                            html = "";
                            if(response.length == 0){
                                html = '<tr class="not-found"><td>Member tidak ditemukan</td></tr>';
                                $('#table_lov_member').append(html);
                            }
                            else{
                                for (i = 0; i < response.length; i++) {
                                    html = '<tr class="row_lov" onclick=lov_member_select("' + response[i].cus_kodemember + '",true)><td>' + response[i].cus_namamember + '</td><td>' + response[i].cus_kodemember + '</td></tr>';
                                    $('#table_lov_member').append(html);
                                }
                            }
                        },
                        complete: function(){
                            $('#m_kodememberHelp').modal({backdrop: 'static', keyboard: true});
                            $('#modal-loader').modal('hide');
                        }
                    });
                }
                else{
                    $('.invalid-feedback').show();
                }
            }
        });

        $('#btn-modal-ktp').on('click',function(){
            field = 'ktp';
        });

        $('#btn-modal-surat').on('click',function(){
            field = 'surat';
        });

        $('#btn-modal-usaha').on('click',function(){
            field = 'usaha';
        });

        $('#search_lov_kodepos').keypress(function (e) {
            if (e.which == 13) {
                if(this.value.length == 0) {
                    $('.invalid-feedback').hide();
                    $('#table_lov_kodepos .row_lov').remove();
                    $('#table_lov_kodepos').append(trlovkodepos);
                }
                else if(this.value.length >= 4) {
                    $('.invalid-feedback').hide();
                    $.ajax({
                        url: '/BackOffice/public/mstmember/lov_kodepos_search',
                        type: 'GET',
                        data: {"_token": "{{ csrf_token() }}", value: this.value.toUpperCase()},
                        beforeSend: function(){
                            $('#m_kodeposHelp').modal({backdrop: 'static', keyboard: false});
                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        },
                        success: function (response) {
                            $('#table_lov_kodepos .row_lov').remove();
                            html = "";
                            for (i = 0; i < response.length; i++) {
                                html = '<tr class="row_lov" onclick="lov_kodepos_select(\'' + response[i].pos_kode + '\',\''+ response[i].pos_kecamatan +'\',\''+ response[i].pos_kelurahan +'\',\''+ response[i].pos_kabupaten+'\')"><td>' + response[i].pos_kelurahan + '</td><td>' + response[i].pos_kecamatan + '</td><td>' + response[i].pos_kabupaten + '</td><td>' + response[i].pos_propinsi + '</td><td>' + response[i].pos_kode + '</td></tr>';
                                $('#table_lov_kodepos').append(html);
                            }
                        },
                        complete: function(){
                            $('#m_kodeposHelp').modal({backdrop: 'static', keyboard: true});
                            $('#modal-loader').modal('hide');
                        }
                    });
                }
                else{
                    $('.invalid-feedback').show();
                }
            }
        });


        $("#cus_tgllahir").datepicker({
            "dateFormat" : "dd/mm/yy"
        });

        $("#crm_tgllhrpasangan").datepicker({
            "dateFormat" : "dd/mm/yy"
        });

        function initial(){
            $('#btn-p_identitas').click();
            $('.kosong').each(function(){
                $(this).removeClass('kosong');
            });

            $(':input').prop('checked',false);
            $('input[id^="cb_"]').each(function(){
                $(this).prop('disabled',true);
                $(this).prop('checked',false);
            });
            $(':input').prop('disabled',true);
            $(':input').val('');
            $('select').prop('disabled',true);

            $('button').each(function(){
                $(this).prop('disabled',true);
            });
            $('#btn-modal-member').prop('disabled',false);

            $('#search_lov_member').prop('disabled',false);
            $('#cus_kodemember').prop('disabled',false);
            $('#cus_kodemember').focus();
        }

        function ready(){
            initial();

            $(':input').prop('disabled',false);
            $('input[id^="cb_"]').each(function(){
                $(this).prop('disabled',false);
            });
            $('select').prop('disabled',false);

            $('button').each(function(){
                $(this).prop('disabled',false);
            });

            $('#i_statusmember').prop('disabled',true);
            $('#i_updateterakhir').prop('disabled',true);
            $('#cus_alamatmember3').prop('disabled',true);
            $('#i_kecamatanktp').prop('disabled',true);
            $('#cus_alamatmember2').prop('disabled',true);
            $('#cus_alamatmember7').prop('disabled',true);
            $('#i_kecamatansurat').prop('disabled',true);
            $('#cus_alamatmember6').prop('disabled',true);
            $('#crm_alamatusaha3').prop('disabled',true);
            $('#pos_kecamatan').prop('disabled',true);
            $('#crm_alamatusaha2').prop('disabled',true);
            $('#i_jeniscustomer2').prop('disabled',true);
            $('#i_jenisoutlet2').prop('disabled',true);
            $('#grp_subgroup').prop('disabled',true);
            $('#grp_kategori').prop('disabled',true);
            $('#grp_subkategori').prop('disabled',true);
            $('#crm_nohppic1').prop('disabled',true);
            $('#crm_nohppic2').prop('disabled',true);
            $('#cus_tglmulai').prop('disabled',true);
            $('#cus_tglregistrasi').prop('disabled',true);
            $('#cus_nokartumember').prop('disabled',true);
            $('#i_alamatnpwp').prop('disabled',true);
            $('#i_kelurahannpwp').prop('disabled',true);
            $('#i_kodeposnpwp').prop('disabled',true);
            $('#i_kotanpwp').prop('disabled',true);

            $('input[id$="_ket"]').each(function (){
                $(this).prop('disabled',true);
            });
        }

        function cek_field_wajib(){
            ok = true;
            $('.diisi').each(function(){
                if($(this).val() != null && $(this).val().length > 0){
                    $(this).removeClass('kosong');
                }
                else{
                    $(this).addClass('kosong');
                    ok = false;
                }
            });

            if(ok){
                id = 'xxxxx';
                cb = '!ok';


                $('.diisi_cb').each(function(){
                    if(id != $(this).attr('id').substr(0,9)){
                        // console.log('id : ' + id);
                        // console.log('cek - ' + $(this).attr('id'));
                        if($(this).is(':checked')){
                            cb = 'ok';
                            ok = true;
                            id = $(this).attr('id').substr(0,9);
                            console.log('ok - ' + $(this).attr('id'));
                        }
                        else ok = false;
                    }
                });
            }

            return ok;
        }

        function lov_member_select(value, load){
            $.ajax({
                url: '/BackOffice/public/mstmember/lov_member_select',
                type:'GET',
                data:{"_token":"{{ csrf_token() }}",value: value},
                beforeSend: function(){
                    if(load) {
                        $('#m_kodememberHelp').modal({backdrop: 'static', keyboard: false});
                    }
                    $('#m_kodememberHelp').modal('hide');
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function(response){
                    $('#modal-loader').modal('hide');

                    if(response == 'not-found'){
                        swal({
                            title: "Data Member Tidak Ditemukan!",
                            text: "Cek kembali kode member",
                            icon: "error",
                            buttons: false,
                            timer: 1250
                        });

                        initial();
                        $('#cus_kodemember').val(value);
                    }
                    else {
                        ready();

                        member = response['member'];
                        ktp = response['ktp'];
                        surat = response['surat'];
                        usaha = response['usaha'];
                        jenismember = response['jenismember'];
                        outlet = response['outlet'];
                        group = response['group'];
                        npwp = response['npwp'];

                        skipKTP = false;

                        if(ktp == null){
                            swal({
                                title: "Kecamatan tidak terdaftar di database!",
                                icon: "error"
                            });

                            skipKTP = true;
                        }

                        $(':input').val('');
                        $(':input').prop('checked',false);

                        $('#cus_kodemember').val(member.cus_kodemember);
                        $('#cus_namamember').val(member.cus_namamember);
                        if(member.cus_recordid == '1'){
                            $('#i_statusmember').val('NON-AKTIF');
                        }
                        else $('#i_statusmember').val('AKTIF');

                        if(member.crm_idsegment == '6')
                            $('#segment').show();
                        else $('#segment').hide();

                        if(nvl(member.cus_modify_dt, 'x') != 'x'){
                            jam = member.cus_modify_dt.substr(-8);
                        }
                        $('#i_updateterakhir').val(member.cus_modify_by + ' ' + formatDate(member.cus_modify_dt) + ' ' + jam);

                        if(member.cus_flagmemberkhusus == 'Y' && member.cus_recordid == null){
                            $('#btn-quisioner').show();
                        }
                        else $('#btn-quisioner').hide();

                        //######################################################### panel identitas 1 ######################################################################
                        $('#cus_noktp').val(member.cus_noktp);
                        $('#cus_alamatmember1').val(member.cus_alamatmember1);
                        $('#cus_alamatmember4').val(member.cus_alamatmember4);

                        if(!skipKTP) {
                            $('#cus_alamatmember4').val(ktp.pos_kelurahan
                            );
                            $('#i_kecamatanktp').val(ktp.pos_kecamatan);
                        }

                        $('#cus_alamatmember2').val(member.cus_alamatmember2);
                        $('#cus_alamatmember3').val(member.cus_alamatmember3);
                        $('#cus_alamatmember5').val(member.cus_alamatmember5);
                        $('#cus_alamatmember8').val(member.cus_alamatmember8);
                        $('#i_kecamatansurat').val(surat.pos_kecamatan);
                        $('#cus_alamatmember6').val(member.cus_alamatmember6);
                        $('#cus_alamatmember7').val(member.cus_alamatmember7);
                        $('#cus_tlpmember').val(member.cus_tlpmember);
                        $('#cus_hpmember').val(member.cus_hpmember);
                        $('#crm_tmptlahir').val(member.crm_tmptlahir);
                        $('#cus_tgllahir').val(formatDate(member.cus_tgllahir));
                        $('#cus_jenismember').val(jenismember.jm_kode);
                        $('#i_jeniscustomer2').val(jenismember.jm_keterangan);
                        $('#cus_kodeoutlet').val(outlet.out_kodeoutlet);
                        $('#i_jenisoutlet2').val(outlet.out_namaoutlet);
                        $('#cus_jarak').val(member.cus_jarak);
                        $('#cus_flagpkp').val(member.cus_flagpkp);
                        $('#cus_npwp').val(member.cus_npwp);
                        $('#cus_flagkredit').val(member.cus_flagkredit);
                        $('#cus_creditlimit').val(member.cus_creditlimit);
                        $('#cus_top').val(member.cus_top);
                        $('#cus_nosalesman').val(member.cus_nosalesman);
                        $('#cus_flagmemberkhusus').val(member.cus_flagmemberkhusus);
                        $('#cus_flagkirimsms').val(member.cus_flagkirimsms);

                        //######################################################### panel identitas 2 ######################################################################
                        if(group != null){
                            idgroupkat = group.grp_idgroupkat;
                            $('#grp_group').val(group.grp_group);
                            $('#grp_subgroup').val(group.grp_subgroup);
                            $('#grp_kategori').val(group.grp_kategori);
                            $('#grp_subkategori').val(group.grp_subkategori);
                        }
                        if(member.crm_jenisanggota == 'R'){
                            $('#cb_jenisanggotaR').prop('checked',true);
                        }
                        else if(member.crm_jenisanggota == 'K'){
                            $('#cb_jenisanggotaK').prop('checked',true);
                        }
                        if(member.crm_jeniskelamin == 'L'){
                            $('#cb_jeniskelaminL').prop('checked',true);
                        }
                        else if(member.crm_jeniskelamin == 'P'){
                            $('#cb_jeniskelaminP').prop('checked',true);
                        }
                        $('#crm_pic1').val(member.crm_pic1);
                        $('#crm_nohppic1').val(member.crm_nohppic1);
                        $('#crm_pic2').val(member.crm_pic2);
                        if($('#crm_nohppic2').val().length > 0)
                            $('#crm_nohppic2').prop('disabled',false);
                        $('#crm_nohppic2').val(member.crm_nohppic2);
                        $('#crm_email').val(member.crm_email);
                        $('#crm_agama').val(to_uppercase(member.crm_agama));
                        $('#crm_pekerjaan').val(member.crm_pekerjaan);
                        $('#crm_namapasangan').val(member.crm_namapasangan);
                        $('#crm_tgllhrpasangan').val(formatDate(member.crm_tgllhrpasangan));
                        $('#crm_jmlanak').val(member.crm_jmlanak);
                        if(member.crm_pendidikanakhir != ''){
                            $('#i_pendidikan').val(member.crm_pendidikanakhir);
                            $('#i_pendidikanX').hide();
                        }
                        else{
                            $('#i_pendidikan').val('X');
                            $('#i_pendidikanX').show();
                        }
                        if($('#i_pendidikan').val() == null){
                            $('#i_pendidikan').val('X');
                            $('#i_pendidikanX').show();
                        }
                        $('#crm_nofax').val(member.crm_nofax);
                        if(member.crm_internet == 'Y'){
                            $('#cb_internetY').prop('checked',true);
                        }
                        else if(member.crm_internet == 'T'){
                            $('#cb_internetT').prop('checked',true);
                        }
                        $('#crm_tipehp').val(member.crm_tipehp);
                        $('#crm_namabank').val(member.crm_namabank);
                        $('#c_metodekirim').val(member.crm_metodekirim);
                        if($('#c_metodekirim').val() == null){
                            $('#c_metodekirim').val('X');
                            $('#c_metodekirimX').show();
                            $('#c_metodekirimX').val(member.crm_metodekirim);
                        }
                        else $('#c_metodekirimX').hide();
                        $('#i_koordinat').val(member.crm_koordinat);

                        //#########################################################panel identitas 3######################################################################
                        $('#crm_alamatusaha1').val(member.crm_alamatusaha1);
                        $('#crm_alamatusaha4').val(member.crm_alamatusaha4);
                        $('#pos_kecamatan').val(usaha.pos_kecamatan);
                        $('#crm_alamatusaha3').val(usaha.pos_kode);
                        $('#crm_alamatusaha2').val(member.crm_alamatusaha2);

                        if(member.crm_jenisbangunan != '')
                            $('#cb_jenisbangunan'+member.crm_jenisbangunan).prop('checked',true);
                        $('#crm_lamatmpt').val(member.crm_lamatmpt);
                        if(member.crm_statusbangunan != '')
                            $('#cb_statusbangunan'+member.crm_statusbangunan).prop('checked',true);
                        $('#crm_kreditusaha').val(member.crm_kreditusaha);
                        $('#crm_bankkredit').val(member.crm_bankkredit);
                        if(member.crm_motor != '' && member.crm_motor != null){
                            $('#i_motor').val(member.crm_motor);
                            $('#cb_jeniskendaraanMotor').prop('checked', true);
                            if($('#i_motor').val() != null) {
                                $('#i_motor').show();
                                $('#i_motorX').hide();
                            }
                            else{
                                $('#i_motor').val('X');
                                $('#i_motor').show();
                                $('#i_motorX').val(member.crm_motor);
                                $('#i_motorX').show();
                            }
                        }
                        else{
                            $('#i_motor').hide();
                            $('#i_motorX').hide();
                        }
                        if(member.crm_mobil != '' && member.crm_mobil != null){
                            $('#i_mobil').val(member.crm_mobil);
                            $('#cb_jeniskendaraanMobil').prop('checked', true);
                            if($('#i_mobil').val() != null) {
                                $('#i_mobil').show();
                                $('#i_mobilX').hide();
                            }
                            else{
                                $('#i_mobil').val('X');
                                $('#i_mobil').show();
                                $('#i_mobilX').val(member.crm_mobil);
                                $('#i_mobilX').show();
                            }
                        }
                        else{
                            $('#i_mobil').hide();
                            $('#i_mobilX').hide();
                        }

                        //######################################################### panel hobby ######################################################################
                        for(i=0;i<response['hobbymember'].length;i++){
                            $('#cb_h'+response['hobbymember'][i].dhb_kodehobby).prop('checked',true);
                            if(response['hobbymember'][i].dhb_keterangan != null || response['hobbymember'][i].dhb_keterangan != ''){
                                $('#cb_h'+response['hobbymember'][i].dhb_kodehobby+'_ket').val(response['hobbymember'][i].dhb_keterangan);
                                $('#cb_h'+response['hobbymember'][i].dhb_kodehobby+'_ket').prop('disabled',false);
                            }
                            else{
                                $('#cb_h'+response['hobbymember'][i].dhb_kodehobby+'_ket').val('');
                            }
                        }

                        //######################################################### panel npwp ######################################################################
                        $('#cus_tglmulai').val(formatDate(member.cus_tglmulai));
                        $('#cus_tglregistrasi').val(formatDate(member.cus_tglregistrasi));
                        $('#cus_flagbebasiuran').val(member.cus_flagbebasiuran);
                        $('#cus_alamatemail').val(member.cus_alamatemail);
                        $('#cus_nokartumember').val(member.cus_nokartumember);
                        $('#cus_flagblockingpengiriman').val(member.cus_flagblockingpengiriman);
                        $('#cus_flaginstitusipemerintah').val(member.cus_flaginstitusipemerintah);

                        if(npwp != '' && npwp != null){
                            $('#i_alamatnpwp').val(npwp.pwp_alamat);
                            $('#i_kelurahannpwp').val(npwp.pwp_kelurahan);
                            $('#i_kotanpwp').val(npwp.pwp_kota);
                            $('#i_kodeposnpwp').val(npwp.pwp_kodepos);
                        }
                        else{
                            $('#i_alamatnpwp').val(member.cus_alamatmember1);
                            $('#i_kelurahannpwp').val(member.cus_alamatmember4);
                            $('#i_kotanpwp').val(member.cus_alamatmember2);
                            $('#i_kodeposnpwp').val(member.cus_alamatmember3);
                        }

                        //######################################################### panel bank ######################################################################
                        for(i=0;i<response['bank'].length;i++){
                            $('#cb_b'+response['bank'][i].cub_kodefasilitasbank).prop('checked',true);
                        }

                        quisioner = response['quisioner'];
                        for(i=0;i<quisioner.length;i++){
                            if(quisioner[i].fpm_flagjual == 'T')
                                jual = 'Y';
                            else jual = '';

                            if(quisioner[i].fpm_flagbeliigr == 'T')
                                beliigr = 'Y';
                            else beliigr = '';

                            if(quisioner[i].fpm_flagbelilain == 'T')
                                belilain = 'Y';
                            else belilain = '';

                            $('#q_'+quisioner[i].fpm_kodeprdcd).find('.dijual').val(jual);
                            $('#q_'+quisioner[i].fpm_kodeprdcd).find('.beli-igr').val(beliigr);
                            $('#q_'+quisioner[i].fpm_kodeprdcd).find('.beli-lain').val(belilain);
                        }
                    }
                }, error : function (err){
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
                },
                complete: function(){
                    if(load){
                        if($('#m_kodememberHelp').is(':visible')) {
                            $('#m_kodememberHelp').modal('toggle');
                            $('#search_lov_member').val('');
                            $('#table_lov_member .row_lov').remove();
                            $('#table_lov_member').append(trlovmember);
                            $('#m_kodememberHelp').modal({backdrop: 'static', keyboard: true});
                        }
                    }
                    $('#modal-loader').modal('hide');
                    $('#cus_namamember').select();
                }
            });
        }

        function lov_kodepos_select(kode, kecamatan, kelurahan, kabupaten){
            success = false;
            $.ajax({
                url: '/BackOffice/public/mstmember/lov_kodepos_select',
                type: 'GET',
                data: {"_token": "{{ csrf_token() }}", kode: kode, kecamatan: kecamatan, kelurahan: kelurahan, kabupaten: kabupaten},
                beforeSend: function(){
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                    $('#m_kodeposHelp').modal('hide');
                },
                success: function (response) {
                    if(response == 'not-found'){
                        swal({
                            title: "Kelurahan tidak terdaftar di database!",
                            text: "Cek ulang inputan kelurahan",
                            icon: "error",
                            buttons: false,
                            timer: 750
                        }).then(function(){
                            if(field == 'ktp'){
                                $('#cus_alamatmember2').val('');
                                $('#cus_alamatmember3').val('');
                                $('#cus_alamatmember4').val('');
                                $('#i_kecamatanktp').val('');
                                $('#cus_alamatmember4').select();
                            }
                            else if(field == 'surat'){
                                $('#cus_alamatmember6').val('');
                                $('#cus_alamatmember7').val('');
                                $('#cus_alamatmember8').val('');
                                $('#i_kecamatansurat').val('');
                                $('#cus_alamatmember8').select();
                            }
                            else if(field == 'usaha'){
                                $('#crm_alamatusaha2').val('');
                                $('#crm_alamatusaha3').val('');
                                $('#crm_alamatusaha4').val('');
                                $('#i_kecamatanusaha').val('');
                                $('#crm_alamatusaha4').select();
                            }
                        });
                        success = false;
                    }
                    else{
                        success = true;

                        kode = response.pos_kode;
                        kecamatan = response.pos_kecamatan;
                        kelurahan = response.pos_kelurahan;
                        kabupaten = response.pos_kabupaten;

                        insert_detail_alamat(kelurahan,kecamatan,kode,kabupaten);
                    }
                },
                error : function (err){
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
                },
                complete: function(){
                    $('#modal-loader').modal('hide');
                    if($('#m_kodeposHelp').is(':visible')){
                        $('#m_kodeposHelp').modal('toggle');
                    }
                    if(success){
                        if(field == 'ktp'){
                            $('#cus_alamatmember5').select();
                        }
                        else if(field == 'surat'){
                            $('#cus_tlpmember').select();
                        }
                        else if(field == 'usaha'){
                            $('#cb_jenisbangunanP').select();
                        }
                    }

                    $('.kosong').each(function(){
                        if($(this).val() != null && $(this).val().length > 0){
                            $(this).removeClass('kosong');
                        }
                    });
                }
            });
        }

        function insert_detail_alamat(kelurahan,kecamatan,kode,kabupaten){
            if(field == 'ktp'){
                $('#cus_alamatmember4').val(kelurahan);
                $('#i_kecamatanktp').val(kecamatan);
                $('#cus_alamatmember3').val(kode);
                $('#cus_alamatmember2').val(kabupaten);

                if($('#cus_alamatmember7').val() == ''){
                    $('#cus_alamatmember8').val(kelurahan);
                    $('#i_kecamatansurat').val(kecamatan);
                    $('#cus_alamatmember7').val(kode);
                    $('#cus_alamatmember6').val(kabupaten);
                }
            }
            else if(field == 'surat'){
                $('#cus_alamatmember8').val(kelurahan);
                $('#i_kecamatansurat').val(kecamatan);
                $('#cus_alamatmember7').val(kode);
                $('#cus_alamatmember6').val(kabupaten);
            }
            else if(field == 'usaha'){
                $('#crm_alamatusaha4').val(kelurahan);
                $('#pos_kecamatan').val(kecamatan);
                $('#crm_alamatusaha3').val(kode);
                $('#crm_alamatusaha2').val(kabupaten);
            }
        }

        function lov_jenismember_select(kode, keterangan){
            $('#cus_jenismember').val(kode);
            $('#i_jeniscustomer2').val(keterangan);

            if($('#m_jenismemberHelp').is(':visible')) {
                $('#m_jenismemberHelp').modal('toggle');
            }
        }

        function lov_jenisoutlet_select(kode, nama){
            $('#cus_kodeoutlet').val(kode);
            $('#i_jenisoutlet2').val(nama);

            if($('#m_jenisoutletHelp').is(':visible')){
                $('#m_jenisoutletHelp').modal('toggle');
            }
        }

        function check_hobby(event){
            if($('#'+event.target.id).is(':checked')){
                $('#'+event.target.id+'_ket').prop('disabled',false);
            }
            else{
                $('#'+event.target.id+'_ket').val('');
                $('#'+event.target.id+'_ket').prop('disabled',true);
            }
        }

        function to_uppercase(value) {
            if(value == '' || value == null)
                return '';
            else return value.toUpperCase();
        }

        function lov_group_select(id){
            for(i=0;i<arrgroup.length;i++){
                if(id.match(/([A-z])/g).length == id.length){
                    if(id == arrgroup[i].grp_group){
                        $('#grp_group').val(arrgroup[i].grp_group);
                        $('#grp_subgroup').val(arrgroup[i].grp_subgroup);
                        $('#grp_kategori').val(arrgroup[i].grp_kategori);
                        $('#grp_subkategori').val(arrgroup[i].grp_subkategori);
                        idgroupkat = arrgroup[i].grp_idgroupkat;
                        break;
                    }
                }
                else{
                    if(id == arrgroup[i].grp_idgroupkat){
                        $('#grp_group').val(arrgroup[i].grp_group);
                        $('#grp_subgroup').val(arrgroup[i].grp_subgroup);
                        $('#grp_kategori').val(arrgroup[i].grp_kategori);
                        $('#grp_subkategori').val(arrgroup[i].grp_subkategori);
                        idgroupkat = arrgroup[i].grp_idgroupkat;
                        break;
                    }
                }
            }

            $('.diisi').each(function(){
                if($(this).val() != null && $(this).val().length > 0){
                    ok = false;
                    $(this).removeClass('kosong');
                }
            });

            if($('#m_groupHelp').is(':visible')){
                $('#m_groupHelp').modal('toggle');
            }

            $('#cb_jenisanggotaR').focus();
        }

        $('#btn-rekam').on('click',function(){
            ok = cek_field_wajib();

            if(ok) {
                swal({
                    title: 'Yakin ingin menyimpan data?',
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((createData) => {
                    if (createData) {
                        var data = {};
                        data['customer'] = {};
                        data['keycustomer'] = [];
                        data['customercrm'] = {};
                        data['keycustomercrm'] = [];
                        data['hobby'] = {};
                        data['hobby_ket'] = {};
                        data['bank'] = {};

                        $('[id^="cus_"]').each(function () {
                            data.customer[$(this).attr('id')] = $(this).val();
                            data.keycustomer.push($(this).attr('id'));
                            // inputValue.push($(this).val());
                        });

                        $('[id^="crm_"]').each(function () {
                            data.customercrm[$(this).attr('id')] = $(this).val();
                            data.keycustomercrm.push($(this).attr('id'));
                            // inputValue.push($(this).val());
                        });

                        indexHobby = 0;
                        for (i = 0; i < arrhobby.length; i++) {
                            if ($('.row_hobby_' + i).find('#cb_h' + $('.row_hobby_' + i).attr('id')).is(':checked')) {
                                data.hobby[indexHobby] = arrhobby[i].hob_kodehobby;
                                data.hobby_ket[indexHobby] = $('.row_hobby_' + i).find('#cb_h' + $('.row_hobby_' + i).attr('id') + '_ket').val();
                                indexHobby++;
                            }
                        }

                        if ($('#cb_jenisanggotaR').is(':checked')) {
                            data.customercrm['crm_jenisanggota'] = 'R';
                        }
                        else data.customercrm['crm_jenisanggota'] = 'K';
                        data.keycustomercrm.push('crm_jenisanggota');

                        if ($('#cb_jeniskelaminL').is(':checked')) {
                            data.customercrm['crm_jeniskelamin'] = 'L';
                        }
                        else data.customercrm['crm_jeniskelamin'] = 'P';
                        data.keycustomercrm.push('crm_jeniskelamin');

                        if ($('#i_pendidikanX').is(':visible')) {
                            data.customercrm['crm_pendidikanakhir'] = $('#i_pendidikanX').val();
                        }
                        else data.customercrm['crm_pendidikanakhir'] = $('#i_pendidikan').val();
                        data.keycustomercrm.push('crm_pendidikanakhir');

                        if ($('#cb_internetY').is(':checked')) {
                            data.customercrm['crm_internet'] = 'Y';
                        }
                        else data.customercrm['crm_internet'] = 'T';
                        data.keycustomercrm.push('crm_internet');

                        if ($('#c_metodekirimX').is(':visible')) {
                            data.customercrm['crm_metodekirim'] = $('#c_metodekirimX').val();
                        }
                        else data.customercrm['crm_metodekirim'] = $('#c_metodekirim').val();
                        data.keycustomercrm.push('crm_metodekirim');

                        if ($('#cb_jenisbangunanP').is(':checked')) {
                            data.customercrm['crm_jenisbangunan'] = 'P';
                        }
                        else if ($('#cb_jenisbangunanS').is(':checked')) {
                            data.customercrm['crm_jenisbangunan'] = 'S';
                        }
                        else data.customercrm['crm_jenisbangunan'] = 'N';
                        data.keycustomercrm.push('crm_jenisbangunan');

                        if ($('#i_statusbangunanM').is(':checked')) {
                            data.customercrm['crm_statusbangunan'] = 'M';
                        }
                        else data.customercrm['crm_statusbangunan'] = 'S';
                        data.keycustomercrm.push('crm_statusbangunan');

                        if ($('#cb_jeniskendaraanMotor').is(':checked')) {
                            if ($('#i_motorX').is(':visible'))
                                data.customercrm['crm_motor'] = $('#i_motorX').val();
                            else data.customercrm['crm_motor'] = $('#i_motor').val();
                        }
                        else data.customercrm['crm_motor'] = '';
                        data.keycustomercrm.push('crm_motor');

                        if ($('#cb_jeniskendaraanMobil').is(':checked')) {
                            if ($('#i_mobilX').is(':visible'))
                                data.customercrm['crm_mobil'] = $('#i_mobilX').val();
                            else data.customercrm['crm_mobil'] = $('#i_mobil').val();
                        }
                        else data.customercrm['crm_mobil'] = '';
                        data.keycustomercrm.push('crm_mobil');

                        data.customercrm['crm_idgroupkat'] = idgroupkat;
                        data.keycustomercrm.push('crm_idgroupkat');

                        if($('#cus_flagmemberkhusus').val() == 'Y')
                            data.customercrm['crm_idsegment'] = '1';
                        else data.customercrm['crm_idsegment'] = '7';
                        data.keycustomercrm.push('crm_idsegment');

                        indexBank = 0;
                        for (i = 0; i < arrbank.length; i++) {
                            if ($('.row_fasilitasperbankan_' + i).find('#cb_b' + $('.row_fasilitasperbankan_' + i).attr('id')).is(':checked')) {
                                data.bank[indexBank] = arrbank[i].fba_kodefasilitasbank;
                                indexBank++;
                            }
                        }

                        console.log(data);

                        $.ajax({
                            url: '/BackOffice/public/mstmember/update_member',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            // data: {kodemember: member.cus_kodemember, member: memberNew, membercrm: membercrmNew},
                            data: data,
                            beforeSend: function () {
                                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                            },
                            success: function (response) {
                                $('#modal-loader').modal('toggle');
                                if (response.status == 'success') {
                                    swal({
                                        title: response['message'],
                                        icon: "success"
                                    });
                                }
                                else {
                                    swal({
                                        title: response.message,
                                        icon: "error"
                                    }).then(function () {
                                        $('#cus_kodemember').val(member.cus_kodemember);
                                        $('#cus_kodemember').select();
                                    });

                                }
                            }
                        });
                    }
                });
            }
            else{
                swal({
                    title: 'Data  yang diinputkan belum lengkap!',
                    icon: "warning",
                    timer: 750,
                    buttons: false,
                }).then(function(){
                    $('#btn-'+$('.kosong').parent().parent().parent().parent().parent().parent().attr('id')).click();
                    $('.kosong').select();
                });
            }
        });

        $('#btn-aktif-nonaktif').on('click',function(){
            if(member.cus_kodeigr != '22'){
                swal({
                    title: 'Data yang akan diproses tidak sesuai dengan cabang anda!',
                    icon: 'error'
                });
            }
            else{
                if(member.cus_recordid == '1'){
                    message = "Kode Anggota " + member.cus_kodemember + " dibuat aktif kembali?";
                    status = '';
                }
                else{
                    message = "Kode Anggota " + member.cus_kodemember + " dibuat tidak aktif?";
                    status = '1';
                }
                swal({
                    title: message,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((createData) => {
                    if (createData) {
                        $('#m_aktifnonaktif').modal('toggle');
                    }
                });
            }
        });

        $('#m_aktifnonaktif').on('shown.bs.modal',function(){
            $('#i_username').val('');
            $('#i_password').val('');
            $('#i_username').select();
        });

        $('#btn-export-crm').on('click',function(){
            swal({
                title: 'Apabila ada perubahan data, pastikan sudah disimpan sebelum diexport ke CRM! Lanjut export?',
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((createData) => {
                if (createData) {
                    $.ajax({
                        url: '/BackOffice/public/mstmember/export_crm',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {kodemember: member.cus_kodemember},
                        beforeSend: function () {
                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        },
                        success: function (response) {
                            $('#modal-loader').modal('toggle');
                            if (response.status == 'success') {
                                swal({
                                    title: response['message'],
                                    icon: "success"
                                });
                            }
                            else {
                                swal({
                                    title: response.message,
                                    icon: "error"
                                }).then(function () {
                                    $('#cus_kodemember').val(member.cus_kodemember);
                                    $('#cus_kodemember').select();
                                });

                            }
                        }
                    });
                }
            });
        });

        $('#btn-quisioner').on('click',function(){
            $('#m_quisioner').modal('toggle');

            $('#q_kodemember').prop('disabled',true);
            $('#q_namamember').prop('disabled',true);

            $('#q_kodemember').val(member.cus_kodemember);
            $('#q_namamember').val(member.cus_namamember);
        });

        $('#btn-q-save').on('click',function(event){
            event.preventDefault();

            var data = {};
            var arrdata = [];

            $('tr[id^="q_"]').each(function() {
                // console.log($(this).find('.dijual').val());
                var data = {};

                data['fpm_kodemember'] = member.cus_kodemember;
                data['fpm_kodeprdcd'] = $(this).attr('id').substr(2);

                if($(this).find('.dijual').val() == 'Y')
                    dijual = 'T';
                else dijual = 'F';

                if($(this).find('.beli-igr').val() == 'Y')
                    beliigr = 'T';
                else beliigr = 'F';

                if($(this).find('.beli-lain').val() == 'Y')
                    belilain = 'T';
                else belilain = 'F';

                data['fpm_flagjual'] = dijual;
                data['fpm_flagbeliigr'] = beliigr;
                data['fpm_flagbelilain'] = belilain;

                arrdata.push(data);
            });

            swal({
                title: "Yakin ingin menyimpan data?",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then((createData) => {
                if (createData) {
                    $.ajax({
                        url: '/BackOffice/public/mstmember/save_quisioner',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {arrdata: arrdata},
                        beforeSend: function () {
                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        },
                        success: function (response) {
                            $('#modal-loader').modal('toggle');
                            $('#m_quisioner').modal('toggle');

                            if (response.status == 'success') {
                                swal({
                                    title: response['message'],
                                    icon: "success"
                                });
                            }
                            else {
                                swal({
                                    title: response.message,
                                    icon: "error"
                                }).then(function () {
                                    $('#cus_kodemember').val(member.cus_kodemember);
                                    $('#cus_kodemember').select();
                                });

                            }
                        }
                    });
                }
            });
        });

        $('#btn-hapus').on('click',function(){
            if(member.cus_kodeigr != '22'){
                swal({
                    title: "Data yang akan diproses tidak sesuai dengan cabang anda!",
                    icon: "error"
                });
            }
            else{
                swal({
                    title: 'Kode anggota ' + member.cus_kodemember + ' dihapus permanen?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then((createData) => {
                    if(createData){
                        swal({
                            title: "Inputkan password untuk melanjutkan",
                            text: "ADMIN (user saat ini)",
                            buttons: true,
                            dangerMode: true,
                            content: {
                                element: "input",
                                attributes: {
                                    placeholder: "Inputkan password",
                                    type: "password",
                                },
                            }
                        }).then((password) => {
                            if (password) {
                                $.ajax({
                                    url: '/BackOffice/public/mstmember/check_password',
                                    type: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: {username: 'VBU', password: password},
                                    beforeSend: function(){
                                        $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                                    },
                                    success: function (response) {
                                        if(response == 'ok'){
                                            $.ajax({
                                                url: '/BackOffice/public/mstmember/hapus_member',
                                                type: 'POST',
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                                data: {kodemember: member.cus_kodemember},
                                                success: function (response) {
                                                    $('#modal-loader').modal('hide');
                                                    if (response.status == 'success') {
                                                        swal({
                                                            title: response['message'],
                                                            icon: "success"
                                                        }).then((createData) => {
                                                            initial();
                                                        });

                                                    }
                                                    else {
                                                        swal({
                                                            title: response.message,
                                                            icon: "error"
                                                        });

                                                    }
                                                }
                                            });
                                        }
                                        else{
                                            $('#modal-loader').modal('hide');
                                            swal({
                                                title: "Password salah!",
                                                icon: "error"
                                            });
                                        }
                                    }
                                });
                            }
                        });
                    }
                });
            }
        });

        $('#i_username').on('keypress',function(event){
            if(event.which == 13 && $(this).val().length > 0){
                $('#i_password').select();
            }
        });

        $('#i_password').on('keypress',function(event){
            if(event.which == 13 && $(this).val().length > 0){
                $('#btn-aktifnonaktif-ok').click();
            }
        })

        $('#btn-aktifnonaktif-ok').on('click',function(){
            user = $('#i_username').val();
            pass = $('#i_password').val();
            aktif_nonaktif(user, pass);
        })

        function aktif_nonaktif(user, pass){
            $.ajax({
                url: '/BackOffice/public/mstmember/check_password',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {username: user, password: pass},
                beforeSend: function(){
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (response) {
                    if(response == 'ok'){
                        $.ajax({
                            url: '/BackOffice/public/mstmember/set_status_member',
                            type: 'GET',
                            data: {"_token": "{{ csrf_token() }}", kode: member.cus_kodemember, status: status},
                            success: function (response) {
                                $('#modal-loader').modal('hide');
                                $('#m_aktifnonaktif').modal('hide');
                                if(response == 'success'){
                                    swal({
                                        title: "Berhasil mengubah status member!",
                                        icon: "success"
                                    }).then(function(){
                                        if(status == ''){
                                            member.cus_recordid = status;
                                            $('#i_statusmember').val('AKTIF');
                                        }
                                        else if(status == '1'){
                                            member.cus_recordid = status;
                                            $('#i_statusmember').val('NON-AKTIF');
                                        }
                                    });
                                }
                                else{
                                    swal({
                                        title: "Gagal mengubah status member!",
                                        icon: "error"
                                    });
                                }
                            }
                        });
                    }
                    else{
                        $('#modal-loader').modal('hide');
                        console.log(response);
                        if(response == 'userlevel'){
                            swal({
                                title: "Anda tidak berhak melakukan approval!",
                                icon: "error"
                            }).then(function(){
                                $('#i_password').select();
                            });
                        }
                        else{
                            swal({
                                title: "Username atau password salah!",
                                icon: "error"
                            }).then(function(){
                                $('#i_password').select();
                            });
                        }
                    }
                }
            });
        }
    </script>
@endsection
