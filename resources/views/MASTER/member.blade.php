@extends('navbar')
@section('title','MASTER | MASTER MEMBER')
@section('content')


    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-9">
                <div class="card border-dark">
                    <div class="card-body">
                        <div class="row text-right">
                            <div class="col-sm-12">
                                <div class="form-group row mb-0">
                                    <label for="cus_kodemember" class="col-sm-2 col-form-label">@lang('Nomor Anggota')</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control diisi" id="cus_kodemember">
                                        <button id="btn-modal-member" type="button" class="btn btn-lov p-0"
                                                data-toggle="modal" data-target="#m_kodememberHelp">
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
                                    <label for="cus_namamember" class="col-sm-2 col-form-label wajib">@lang('Nama Anggota')<span
                                            class="wajib">*</span></label>
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
                            <a class="nav-link active" id="btn-p_identitas" data-toggle="tab" href="#p_identitas">@lang('Identitas')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="btn-p_identitas2" data-toggle="tab" href="#p_identitas2">@lang('Identitas 2')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="btn-p_identitas3" data-toggle="tab" href="#p_identitas3">@lang('Identitas 3')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="btn-p_hobby" data-toggle="tab" href="#p_hobby">Hobby</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="btn-p_npwp" data-toggle="tab" href="#p_alamatnpwp">@lang('Alamat NPWP')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="btn-p_fasilitasbank" data-toggle="tab" href="#p_fasilitasbank">@lang('Fasilitas Perbankan')</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div id="p_identitas" class="container-fluid tab-pane active pl-0 pr-0 fix-height">
                            <div class="card-body ">
                                <div class="row text-right">
                                    <div class="col-sm-12">
                                        <div class="form-group row mb-0">
                                            <label for="cus_noktp" class="col-sm-2 col-form-label">@lang('No. KTP')<span
                                                    class="wajib">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control diisi" id="cus_noktp"
                                                       maxlength="16"
                                                       oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                            </div>
                                            <span class="text-danger" id="message-error" style="display: none">@lang('* Nomor KTP harus 16 digit')</span>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_alamatmember1" class="col-sm-2 col-form-label">@lang('Alamat KTP')<span class="wajib">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control diisi" id="cus_alamatmember1">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_alamatmember4"
                                                   class="col-sm-2 col-form-label">@lang('Kelurahan')<span class="wajib">*</span></label>
                                            <div class="col-sm-3 buttonInside">
                                                <input type="text" class="form-control diisi" id="cus_alamatmember4">
                                                <button id="btn-modal-ktp" type="button" class="btn btn-lov p-0"
                                                        data-toggle="modal" data-target="#m_kodeposHelp">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>

                                            {{--                                            <div class="col-sm-3">--}}
                                            {{--                                                <input type="text" class="form-control diisi" id="cus_alamatmember4">--}}
                                            {{--                                            </div>--}}
                                            {{--                                            <div class="col-sm-1 p-0">--}}
                                            {{--                                                <button id="btn-modal-ktp" type="button" class="btn p-0 float-left" data-toggle="modal" data-target="#m_kodeposHelp"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>--}}
                                            {{--                                            </div>--}}
                                            <label for="i_kecamatanktp" class="col-sm-3 col-form-label">@lang('Kecamatan')<span
                                                    class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi" id="i_kecamatanktp">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_alamatmember3" class="col-sm-2 col-form-label">@lang('Kode Pos')<span
                                                    class="wajib">*</span></label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control diisi" id="cus_alamatmember3">
                                            </div>
                                            <label for="cus_alamatmember2" class="col-sm-4 col-form-label">@lang('Kota')<span
                                                    class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi" id="cus_alamatmember2">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_alamatmember5" class="col-sm-2 col-form-label">@lang('Alamat Surat')<span class="wajib">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control diisi" id="cus_alamatmember5">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_alamatmember8"
                                                   class="col-sm-2 col-form-label">@lang('Kelurahan')<span class="wajib">*</span></label>
                                            <div class="col-sm-3 buttonInside">
                                                <input type="text" class="form-control diisi" id="cus_alamatmember8">
                                                <button id="btn-modal-surat" type="button" class="btn btn-lov p-0"
                                                        data-toggle="modal" data-target="#m_kodeposHelp">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>

                                            {{--                                            <div class="col-sm-3">--}}
                                            {{--                                                <input type="text" class="form-control diisi" id="cus_alamatmember8">--}}
                                            {{--                                            </div>--}}
                                            {{--                                            <div class="col-sm-1 p-0">--}}
                                            {{--                                                <button id="btn-modal-surat" type="button" class="btn p-0 float-left" data-toggle="modal" data-target="#m_kodeposHelp"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>--}}
                                            {{--                                            </div>--}}
                                            <label for="i_kecamatansurat" class="col-sm-3 col-form-label">@lang('Kecamatan')<span
                                                    class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi" id="i_kecamatansurat">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_alamatmember7" class="col-sm-2 col-form-label">@lang('Kode Pos')<span
                                                    class="wajib">*</span></label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control diisi" id="cus_alamatmember7">
                                            </div>
                                            <label for="cus_alamatmember6" class="col-sm-4 col-form-label">@lang('Kota')<span
                                                    class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi" id="cus_alamatmember6">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_tlpmember" class="col-sm-2 col-form-label">@lang('Telepon')<span
                                                    class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi" id="cus_tlpmember">
                                            </div>
                                            <label for="cus_hpmember" class="col-sm-3 col-form-label">@lang('HP')<span
                                                    class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi" id="cus_hpmember"
                                                       disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_tmptlahir" class="col-sm-2 col-form-label">@lang('Tempat Lahir')<span
                                                    class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi" id="crm_tmptlahir">
                                            </div>
                                            <label for="cus_tgllahir" class="col-sm-3 col-form-label">@lang('Tgl. Lahir')<span
                                                    class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi" id="cus_tgllahir"
                                                       placeholder="dd/mm/yyyy" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_jeniscustomer" class="col-sm-2 col-form-label">@lang('Jenis Customer')</label>
                                            <div class="col-sm-1 buttonInside">
                                                <input type="text" class="form-control" id="cus_jenismember">
                                                <button id="btn-modal-surat" type="button" class="btn btn-lov p-0"
                                                        data-toggle="modal" data-target="#m_jenismemberHelp">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>
                                            <div class="col-sm-2 pl-0">
                                                <input type="text" class="form-control" id="i_jeniscustomer2">
                                            </div>

                                            <label for="i_jenisoutlet" class="col-sm-2 offset-sm-1 col-form-label">@lang('Jenis Outlet')<span class="wajib">*</span></label>
                                            <div class="col-sm-1 buttonInside">
                                                <input type="text" class="form-control diisi" id="cus_kodeoutlet">
                                                <button id="btn-modal-outlet" type="button" class="btn btn-lov p-0"
                                                        data-toggle="modal" data-target="#m_jenisoutletHelp">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>
                                            <div class="col-sm-2 pl-0">
                                                <input type="text" class="form-control" id="i_jenisoutlet2">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_jarak" class="col-sm-2 col-form-label">@lang('Jarak')</label>
                                            <div class="col-sm-2">
                                                <input type="number" min="0" class="form-control" id="cus_jarak">
                                            </div>

                                            <label for="i_suboutlet" class="col-sm-2 offset-sm-2 col-form-label">@lang('Sub Outlet')<span class="wajib">*</span></label>
                                            <div class="col-sm-1 buttonInside">
                                                <input type="text" class="form-control " id="cus_kodesuboutlet">
                                                <button id="btn-modal-suboutlet" type="button" class="btn btn-lov p-0"
                                                        onclick="view_sub_outlet()">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>
                                            <div class="col-sm-2 pl-0">
                                                <input type="text" class="form-control" id="i_suboutlet2">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_flagpkp" class="col-sm-2 col-form-label">@lang('PKP')</label>
                                            <div class="col-sm-1">
                                                <input type="text" maxlength="1" class="form-control" id="cus_flagpkp">
                                            </div>
                                            <label for="cus_flagpkp" class="col-sm-1 col-form-label pl-0 text-left">[ Y
                                                / T ]</label>
                                            <label for="cus_npwp" class="col-sm-4 col-form-label">@lang('NPWP')</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="cus_npwp">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_flagkredit" class="col-sm-2 col-form-label">@lang('Flag Kredit')</label>
                                            <div class="col-sm-1">
                                                <input type="text" maxlength="1" class="form-control"
                                                       id="cus_flagkredit">
                                            </div>
                                            <label for="cus_flagkredit" class="col-sm-1 col-form-label pl-0 text-left">[
                                                Y / T ]</label>
                                            <label for="cus_creditlimit" class="col-sm-1 col-form-label">@lang('Limit')</label>
                                            <div class="col-sm-2">
                                                <input type="number" min="0" class="form-control" id="cus_creditlimit">
                                            </div>
                                            <label for="cus_top" class="col-sm-1 col-form-label">@lang('TOP')</label>
                                            <div class="col-sm-1">
                                                <input type="number" min="0" class="form-control" id="cus_top">
                                            </div>
                                            <label for="cus_creditlimit" class="col-sm-1 col-form-label text-left pl-0">@lang('Hari')</label>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_nosalesman" class="col-sm-2 col-form-label">@lang('Salesman')</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="cus_nosalesman"
                                                       maxlength="3">
                                            </div>
                                            <label for="cus_flagmemberkhusus" class="col-sm-4 col-form-label">@lang('Member Khusus')</label>
                                            <div class="col-sm-1">
                                                <input type="text" maxlength="1" class="form-control"
                                                       id="cus_flagmemberkhusus" disabled>
                                            </div>
                                            <label for="cus_flagpkp" class="col-sm-1 col-form-label pl-0 text-left">[ Y
                                                / ]</label>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_flagkirimsms" class="col-sm-2 col-form-label">@lang('Kirim SMS')</label>
                                            <div class="col-sm-1">
                                                <input type="text" maxlength="1" class="form-control"
                                                       id="cus_flagkirimsms">
                                            </div>
                                            <label for="cus_flagkirimsms"
                                                   class="col-sm-1 col-form-label pl-0 text-left">[ Y / T ]</label>
                                            {{--                                            <label for="i_flag_ina" class="col-sm-4 col-form-label d-flag-ina">Flag Bank INA<span class="wajib">*</span></label>--}}
                                            <label for="i_flag_ina" class="col-sm-4 col-form-label d-flag-ina">@lang('Flag Bank INA')</label>
                                            <div class="col-sm-1 d-flag-ina">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    {{--                                                    <input type="checkbox" class="custom-control-input diisi_cb" id="cb_flag_ina">--}}
                                                    {{--                                                    pak remus jaluk diilange required e--}}
                                                    <input type="checkbox" class="custom-control-input"
                                                           id="cb_flag_ina">
                                                    <label class="custom-control-label" for="cb_flag_ina"></label>
                                                </div>
                                            </div>
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
                                            <label for="grp_group" class="col-sm-2 col-form-label">@lang('Group')<span
                                                    class="wajib">*</span></label>
                                            <div class="col-sm-2 buttonInside">
                                                <input type="text" class="form-control diisi" id="grp_group">
                                                <button id="btn-modal-group" type="button" class="btn btn-lov p-0"
                                                        data-toggle="modal" data-target="#m_groupHelp">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>

                                            {{--                                            <div class="col-sm-2">--}}
                                            {{--                                                <input type="text" class="form-control diisi" id="grp_group">--}}
                                            {{--                                            </div>--}}
                                            {{--                                            <div class="col-sm-1 p-0">--}}
                                            {{--                                                <button id="btn-modal-group" type="button" class="btn p-0 float-left" data-toggle="modal" data-target="#m_groupHelp"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>--}}
                                            {{--                                            </div>--}}
                                            <label for="grp_kategori" class="col-sm-4 col-form-label">@lang('Kategori')</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi" id="grp_kategori">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="grp_subgroup" class="col-sm-2 col-form-label">@lang('Sub Group')</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi" id="grp_subgroup">
                                            </div>
                                            <label for="grp_subkategori" class="col-sm-3 col-form-label">@lang('Sub Kategori')</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi" id="grp_subkategori">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_jenisanggota" class="col-sm-2 col-form-label">@lang('Jenis Anggota')<span class="wajib">*</span></label>
                                            <div class="col-sm">
                                                <div class="row ml-1">
                                                    <div class="col-sm">
                                                        <div class="custom-control custom-checkbox mt-2 text-left">
                                                            <input type="checkbox" class="custom-control-input diisi_cb"
                                                                   id="cb_jenisanggotaR">
                                                            <label class="custom-control-label" for="cb_jenisanggotaR">@lang('Regular')</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm">
                                                        <div class="custom-control custom-checkbox mt-2 text-left">
                                                            <input type="checkbox" class="custom-control-input diisi_cb"
                                                                   id="cb_jenisanggotaK">
                                                            <label class="custom-control-label" for="cb_jenisanggotaK">@lang('Khusus')</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <label for="i_jeniskelamin" class="col-sm-2 col-form-label">@lang('Jenis Kelamin')<span class="wajib">*</span></label>
                                            <div class="col-sm">
                                                <div class="row ml-1">
                                                    <div class="col-sm">
                                                        <div class="custom-control custom-checkbox mt-2 text-left">
                                                            <input type="checkbox"
                                                                   class="checkbox-inline custom-control-input diisi_cb"
                                                                   id="cb_jeniskelaminL">
                                                            <label class="custom-control-label" for="cb_jeniskelaminL">@lang('Laki-laki')</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm">
                                                        <div class="custom-control custom-checkbox mt-2 text-left">
                                                            <input type="checkbox" class="custom-control-input diisi_cb"
                                                                   id="cb_jeniskelaminP">
                                                            <label class="custom-control-label" for="cb_jeniskelaminP">@lang('Perempuan')</label>
                                                        </div>
                                                    </div>
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
                                            <label for="crm_email" class="col-sm-2 col-form-label">@lang('Alamat Email')<span
                                                    class="wajib">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="email" class="form-control diisi" id="crm_email">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_agama" class="col-sm-2 col-form-label">@lang('Agama')<span
                                                    class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <select class="browser-default custom-select diisi" id="crm_agama">
                                                    <option selected disabled>@lang('Pilih Agama')</option>
                                                    <option value="ISLAM">@lang('Islam')</option>
                                                    <option value="KRISTEN">@lang('Kristen')</option>
                                                    <option value="KATHOLIK">@lang('Katholik')</option>
                                                    <option value="BUDHA">@lang('Budha')</option>
                                                    <option value="HINDU">@lang('Hindu')</option>
                                                    <option value="ALIRAN">@lang('Aliran Kepercayaan')</option>
                                                </select>
                                            </div>
                                            <label for="crm_pekerjaan" class="col-sm-3 col-form-label crm-pekerjaan">@lang('Pekerjaan')</label>
                                            <div class="col-sm-3 crm-pekerjaan">
                                                <select class="browser-default custom-select" id="crm_pekerjaan">
                                                    <option selected disabled>@lang('Pilih Pekerjaan')</option>
                                                    <option value="wiraswasta">@lang('Wiraswasta')</option>
                                                    <option value="pegawainegeri">@lang('Pegawai Negeri')</option>
                                                    <option value="pegawaiswasta">@lang('Pegawai Swasta')</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_namapasangan" class="col-sm-2 col-form-label">@lang('Nama Suami / Istri')</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="crm_namapasangan">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_tgllhrpasangan" class="col-sm-2 col-form-label">@lang('Tgl. Lahir Pasangan')</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="crm_tgllhrpasangan"
                                                       placeholder="dd/mm/yyyy">
                                            </div>
                                            <label for="crm_jmlanak" class="col-sm-3 col-form-label">@lang('Jumlah Anak')</label>
                                            <div class="col-sm-1">
                                                <input type="number" min="0" class="form-control" id="crm_jmlanak">
                                            </div>
                                            <label for="crm_jmlanak"
                                                   class="col-sm-1 pl-0 text-left col-form-label">@lang('Anak')</label>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_pendidikan" class="col-sm-2 col-form-label">@lang('Pendidikan Terakhir')</label>
                                            <div class="col-sm-3">
                                                <select class="browser-default custom-select" id="i_pendidikan">
                                                    <option selected disabled>...</option>
                                                    <option value="SD">@lang('SD')</option>
                                                    <option value="SLTP">@lang('SLTP')</option>
                                                    <option value="SLTA">@lang('SLTA')</option>
                                                    <option value="S-1">@lang('S-1')</option>
                                                    <option value="S-2">@lang('S-2')</option>
                                                    <option value="S-3">@lang('S-3')</option>
                                                    <option value="X">@lang('Lainnya')</option>
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
                                            <label for="i_internet" class="col-sm-5 col-form-label">@lang('Apakah HP Anda menggunakan Layanan Data / Internet')<span class="wajib">*</span></label>
                                            <div class="col-sm">
                                                <div class="row ml-1">
                                                    <div class="col-sm">
                                                        <div class="custom-control custom-checkbox mt-2 text-left">
                                                            <input type="checkbox" class="custom-control-input diisi_cb"
                                                                   id="cb_internetY">
                                                            <label class="custom-control-label"
                                                                   for="cb_internetY">@lang('Ya')</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm">
                                                        <div class="custom-control custom-checkbox mt-2 text-left">
                                                            <input type="checkbox" class="custom-control-input diisi_cb"
                                                                   id="cb_internetT">
                                                            <label class="custom-control-label"
                                                                   for="cb_internetT">@lang('Tidak')</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_tipehp" class="col-sm-5 col-form-label">@lang('Merk dan Tipe HP yang digunakan')</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="crm_tipehp">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_namabank" class="col-sm-5 col-form-label">@lang('Bank yang sekarang digunakan')<span class="wajib">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control diisi" id="crm_namabank">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="c_metodekirim" class="col-sm-5 col-form-label">@lang('Metode yang paling disukai dalam')<br>@lang(' menyampaikan informasi')<span
                                                    class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <select class="browser-default custom-select diisi" id="c_metodekirim">
                                                    <option selected disabled>...</option>
                                                    <option value="POSR">@lang('Pos ke alamat rumah')</option>
                                                    <option value="POSK">@lang('Pos ke alamat tempat usaha')</option>
                                                    <option value="EMAIL">@lang('e-mail')</option>
                                                    <option value="SMS">@lang('SMS')</option>
                                                    <option value="X">@lang('Lainnya')</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3 pl-0">
                                                <input type="text" class="form-control" id="c_metodekirimX">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_koordinat" class="col-sm-5 col-form-label">@lang('Koordinat Tempat Usaha')</label>
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
                                            <label for="crm_alamatusaha1" class="col-sm-2 pl-0 col-form-label">@lang('Alamat Tempat Usaha')<span class="wajib">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control diisi id3" id="crm_alamatusaha1">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_alamatusaha4" class="col-sm-2 col-form-label">@lang('Kelurahan')<span
                                                    class="wajib">*</span></label>
                                            <div class="col-sm-3 buttonInside">
                                                <input type="text" class="form-control diisi id3" id="crm_alamatusaha4">
                                                <button id="btn-modal-usaha" type="button" class="btn btn-lov p-0"
                                                        data-toggle="modal" data-target="#m_kodeposHelp">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>

                                            {{--                                            <div class="col-sm-3">--}}
                                            {{--                                                <input type="text" class="form-control diisi" id="crm_alamatusaha4">--}}
                                            {{--                                            </div>--}}
                                            {{--                                            <div class="col-sm-1 p-0">--}}
                                            {{--                                                <button id="btn-modal-usaha" type="button" class="btn p-0 float-left" data-toggle="modal" data-target="#m_kodeposHelp"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>--}}
                                            {{--                                            </div>--}}
                                            <label for="pos_kecamatan" class="col-sm-3 col-form-label">@lang('Kecamatan')<span
                                                    class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi id3" id="pos_kecamatan">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_alamatusaha3" class="col-sm-2 col-form-label">@lang('Kode Pos')<span
                                                    class="wajib">*</span></label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control diisi id3" id="crm_alamatusaha3">
                                            </div>
                                            <label for="crm_alamatusaha2" class="col-sm-4 col-form-label">@lang('Kota')<span
                                                    class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control diisi id3" id="crm_alamatusaha2">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_jenisusaha" class="col-sm-4 col-form-label">@lang('Apakah jenis Tempat Usaha Anda?')<span class="wajib">*</span></label>
                                            <div class="col-sm">
                                                <div class="row ml-1">
                                                    <div class="col-sm">
                                                        <div class="custom-control custom-checkbox mt-2 text-left">
                                                            <input type="checkbox"
                                                                   class="custom-control-input diisi_cb id3"
                                                                   id="cb_jenisbangunanP">
                                                            <label class="custom-control-label" for="cb_jenisbangunanP">@lang('Permanen')</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm">
                                                        <div class="custom-control custom-checkbox mt-2 text-left">
                                                            <input type="checkbox"
                                                                   class="custom-control-input diisi_cb id3"
                                                                   id="cb_jenisbangunanS">
                                                            <label class="custom-control-label" for="cb_jenisbangunanS">@lang('Semi Permanen')</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm">
                                                        <div class="custom-control custom-checkbox mt-2 text-left">
                                                            <input type="checkbox"
                                                                   class="custom-control-input diisi_cb id3"
                                                                   id="cb_jenisbangunanN">
                                                            <label class="custom-control-label" for="cb_jenisbangunanN">@lang('Non Permanen')</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_lamatmpt" class="col-sm-2 col-form-label">@lang('Lama menempati')<span class="wajib">*</span></label>
                                            <div class="col-sm-1">
                                                <input type="number" min="0" class="form-control diisi id3"
                                                       id="crm_lamatmpt">
                                            </div>
                                            <label for="crm_lamatmpt" class="col-sm-1 pl-0 text-left col-form-label">@lang('Tahun')</label>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_statusbangunan" class="col-sm-2 col-form-label">@lang('Status Bangunan')<span class="wajib">*</span></label>
                                            <div class="col">
                                                <div class="row ml-1">
                                                    <div class="col-sm">
                                                        <div class="custom-control custom-checkbox mt-2 text-left">
                                                            <input type="checkbox"
                                                                   class="custom-control-input diisi_cb id3"
                                                                   id="cb_statusbangunanM">
                                                            <label class="custom-control-label"
                                                                   for="cb_statusbangunanM">@lang('Milik Sendiri')</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm">
                                                        <div class="custom-control custom-checkbox mt-2 text-left">
                                                            <input type="checkbox"
                                                                   class="custom-control-input diisi_cb id3"
                                                                   id="cb_statusbangunanS">
                                                            <label class="custom-control-label"
                                                                   for="cb_statusbangunanS">@lang('Sewa')</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_kreditusaha" class="col-sm-2 col-form-label">@lang('Kredit Usaha')</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="crm_kreditusaha">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="crm_bankkredit" class="col-sm-2 pl-0 col-form-label">@lang('Bank Penerima Kredit')</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="crm_bankkredit">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_jeniskendaraan" class="col-sm-2 col-form-label">@lang('Jenis Kendaraan')</label>
                                            <div class="col-sm-2">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input"
                                                           id="cb_jeniskendaraanMotor">
                                                    <label class="custom-control-label" for="cb_jeniskendaraanMotor">@lang('Motor')</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 pl-0 pr-0">
                                                <select class="browser-default custom-select" id="i_motor">
                                                    <option selected disabled>...</option>
                                                    <option value="HONDA">HONDA</option>
                                                    <option value="YAMAHA">YAMAHA</option>
                                                    <option value="KAWASAKI">KAWASAKI</option>
                                                    <option value="SUZUKI">SUZUKI</option>
                                                    <option value="X">@lang('LAINNYA')</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3 pl-0">
                                                <input type="text" class="form-control" id="i_motorX">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_jeniskendaraan" class="col-sm-2 col-form-label"></label>
                                            <div class="col-sm-2">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input"
                                                           id="cb_jeniskendaraanMobil">
                                                    <label class="custom-control-label" for="cb_jeniskendaraanMobil">@lang('Mobil')</label>
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
                                                    <option value="X">@lang('LAINNYA')</option>
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
                                                        <th class="col-sm-5">@lang('Nama Hobby')</th>
                                                        <th class="col-sm-1"></th>
                                                        <th class="col-sm-6">@lang('Keterangan')</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php $i = 0 @endphp
                                                    @foreach($hobby as $h)
                                                        <tr class="row_hobby_{{ $i }} d-flex"
                                                            id="{{ $h->hob_kodehobby }}">
                                                            <td class="col-sm-5"><label for="grp_group"
                                                                                        class="col-sm-12 col-form-label">{{ $h->hob_namahobby }}</label>
                                                            </td>
                                                            <td class="col-sm-1">
                                                                <div class="custom-control custom-checkbox text-center">
                                                                    <input onchange="check_hobby(event)" type="checkbox"
                                                                           class="custom-control-input"
                                                                           id="cb_h{{ $h->hob_kodehobby }}">
                                                                    <label class="custom-control-label mt-2"
                                                                           for="cb_h{{ $h->hob_kodehobby }}"></label>
                                                                </div>
                                                            </td>
                                                            <td class="col-sm-6">
                                                                <input disabled type="text" class="form-control"
                                                                       id="cb_h{{ $h->hob_kodehobby }}_ket">
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
                                            <label for="cus_tglmulai" class="col-sm-3 pl-0 col-form-label">@lang('Tanggal Mulai')</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="cus_tglmulai"
                                                       placeholder="DD-MON-YYYY">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_tglregistrasi" class="col-sm-3 pl-0 col-form-label">@lang('Tanggal Registrasi')</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="cus_tglregistrasi"
                                                       placeholder="DD-MON-YYYY">
                                            </div>
                                            <label for="cus_flagbebasiuran" class="col-sm-4 pl-0 col-form-label">@lang('Bebas Iuran')</label>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control" id="cus_flagbebasiuran">
                                            </div>
                                            <label for="cus_flagbebasiuran"
                                                   class="col-sm-1 pl-0 text-left col-form-label">( Y / )</label>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_alamatemail" class="col-sm-3 pl-0 col-form-label">@lang('Alamat Email')</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="cus_alamatemail">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_nokartumember" class="col-sm-3 pl-0 col-form-label">@lang('Nomor Kartu')</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="cus_nokartumember">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="cus_flagblockingpengiriman"
                                                   class="col-sm-3 pl-0 col-form-label">@lang('Blocking Pengiriman')</label>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control" id="cus_flagblockingpengiriman">
                                            </div>
                                            <label for="cus_flagbebasiuran"
                                                   class="col-sm-1 pl-0 text-left col-form-label">( Y / )</label>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cus_flaginstitusipemerintah"
                                                   class="col-sm-3 pl-0 col-form-label">@lang('Flag Institusi Pemerintah')</label>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control"
                                                       id="cus_flaginstitusipemerintah">
                                            </div>
                                            <label for="cus_flaginstitusipemerintah"
                                                   class="col-sm-1 pl-0 text-left col-form-label">( Y / )</label>
                                        </div>

                                        <fieldset class="card border-secondary">
                                            <div class="card-header pb-0">
                                                <h5 class="text-left">@lang('NPWP')</h5>
                                            </div>
                                            <div class="card-body ">
                                                <div class="row text-right">
                                                    <div class="col-sm-12">
                                                        <div class="form-group row mb-0">
                                                            <label for="i_alamatnpwp"
                                                                   class="col-sm-3 pl-0 col-form-label">@lang('Alamat')</label>
                                                            <div class="col-sm-8 pl-0">
                                                                <input type="text" class="form-control"
                                                                       id="i_alamatnpwp">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="i_kelurahannpwp"
                                                                   class="col-sm-3 pl-0 col-form-label">@lang('Kelurahan')</label>
                                                            <div class="col-sm-3 pl-0">
                                                                <input type="text" class="form-control"
                                                                       id="i_kelurahannpwp">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="i_kotanpwp"
                                                                   class="col-sm-3 pl-0 col-form-label">@lang('Kota')</label>
                                                            <div class="col-sm-3 pl-0">
                                                                <input type="text" class="form-control" id="i_kotanpwp">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="i_kodeposnpwp"
                                                                   class="col-sm-3 pl-0 col-form-label">@lang('Kode Pos')</label>
                                                            <div class="col-sm-2 pl-0">
                                                                <input type="text" class="form-control"
                                                                       id="i_kodeposnpwp">
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
                                                <table id="table_fasilitas_perbankan"
                                                       class="table table-sm table-bordered mb-0">
                                                    <thead>
                                                    </thead>
                                                    <tbody>
                                                    @php $i = 0; @endphp
                                                    @foreach($fasilitasperbankan as $fp)
                                                        <tr class="row_fasilitasperbankan_{{ $i }} d-flex"
                                                            id="{{ $fp->fba_kodefasilitasbank }}">
                                                            <td class="col-sm-1">
                                                                <div class="custom-control custom-checkbox text-center">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                           id="cb_b{{ $fp->fba_kodefasilitasbank }}">
                                                                    <label class="custom-control-label ml-1"
                                                                           for="cb_b{{ $fp->fba_kodefasilitasbank }}"></label>
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
                                    <label for="i_updateterakhir" class="col-sm-2 col-form-label">@lang('Update Terakhir')</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="i_updateterakhir">
                                    </div>
                                    <label for="i_harusdiisi" class="col-sm-4 text-right"><span class="wajib">@lang('*Harus diisi / ( - ) bila memang tidak memiliki data')</span></label>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-sm-2 offset-sm-4">
                                        <button id="btn-rekam" class="btn btn-success btn-block" disabled>@lang('SIMPAN')
                                        </button>
                                    </div>
                                    <div class="col-sm-2">
                                        <button id="btn-aktif-nonaktif" class="btn btn-primary btn-block" disabled>@lang('AKTIF / NONAKTIF')
                                        </button>
                                    </div>
                                    <div class="col-sm-2">
                                        <button id="btn-quisioner" class="btn btn-info btn-block" style="display:none">@lang('QUISIONER')
                                        </button>
                                    </div>
                                    <div class="col-sm-2">
                                        <button id="btn-export-crm" class="btn btn-success btn-block" disabled>@lang('EXPORT KE CRM')
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group row mt-2">
                                    <div class="col-sm-2">
                                        <button id="btn-hapus" class="btn btn-danger btn-block" disabled>@lang('HAPUS')</button>
                                    </div>
                                    <div class="col-sm-4 offset-sm-2">
                                        <button id="btn-download-mktho" class="btn btn-primary btn-block" disabled>@lang('DOWNLOAD CUSTOMER DR MKTHO')
                                        </button>
                                    </div>
                                    <div class="col-sm-2">
                                        <button id="btn-check-registrasi" class="btn btn-primary btn-block" disabled>@lang('CEK TGL REGISTRASI')
                                        </button>
                                    </div>
                                    <div class="col-sm-2">
                                        {{--                                        <p>Last Edited : {{ max([date("d-m-Y", filemtime(resource_path('views\MASTER\member.blade.php'))),date("d-m-Y", filemtime(app_path('Http\Controllers\MASTER\MemberController.php')))]) }}--}}
                                        </p>
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
    <div class="modal fade" id="m_kodememberHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
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
                                        <th>@lang('Nama Member')</th>
                                        <th>@lang('Kode Member')</th>
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

    <div class="modal fade" id="m_kodeposHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Master Kode POS')</h5>
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
                                        <th>@lang('Kelurahan')</th>
                                        <th>@lang('Kecamatan')</th>
                                        <th>@lang('Kota')</th>
                                        <th>@lang('Provinsi')</th>
                                        <th>@lang('Kode Pos')</th>
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

    <div class="modal fade" id="m_jenismemberHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Master Jenis Member')</h5>
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
                                        <th>@lang('Keterangan')</th>
                                        <th>@lang('Kode')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($jenismember as $jm)
                                        <tr onclick="lov_jenismember_select('{{ $jm->jm_kode }}','{{ $jm->jm_keterangan }}')"
                                            class="row_lov">
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

    <div class="modal fade" id="m_jenisoutletHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Master Jenis Outlet')</h5>
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
                                        <th>@lang('Kode')</th>
                                        <th>@lang('Nama')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($jenisoutlet as $jo)
                                        <tr onclick="lov_jenisoutlet_select('{{ $jo->out_kodeoutlet }}','{{ $jo->out_namaoutlet }}')"
                                            class="row_lov">
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

    <div class="modal fade" id="m_suboutletHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Master Jenis Outlet')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_suboutlet">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>@lang('Kode')</th>
                                        <th>@lang('Nama')</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody_table_lov_suboutlet">
                                    {{--                                    @foreach($jenisoutlet as $jo)--}}
                                    {{--                                        <tr onclick="lov_jenisoutlet_select('{{ $jo->out_kodeoutlet }}','{{ $jo->out_namaoutlet }}')" class="row_lov">--}}
                                    {{--                                            <td>{{ $jo->out_kodeoutlet }}</td>--}}
                                    {{--                                            <td>{{ $jo->out_namaoutlet }}</td>--}}
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

    <div class="modal fade" id="m_groupHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Master Group</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_group">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>@lang('Group')</th>
                                        <th>@lang('Subgroup')</th>
                                        <th>@lang('Kategori')</th>
                                        <th>@lang('Subkategori')</th>
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

    <div class="modal fade" id="m_quisioner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <fieldset class="card border-secondary">
                                    <legend class="w-auto ml-3">@lang('Quisioner Member Khusus')</legend>
                                    <div class="card-body">
                                        <div class="row text-right">
                                            <div class="col-sm-12">
                                                <div class="form-group row mb-0">
                                                    <label for="q_kodemember" class="col-sm-3 col-form-label">@lang('Kode Member')</label>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" id="q_kodemember">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="q_namamember" class="col-sm-3 col-form-label wajib">@lang('Nama Member')</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="q_namamember">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="table-wrapper-scroll-y my-custom-scrollbar-hobby mb-2"
                                                 style="height: 50vh">
                                                <table class="table table-sm mb-0" id="table_quisioner">
                                                    <thead>
                                                    <tr class="text-center">
                                                        <td>@lang('Item')</td>
                                                        <td>@lang('Dijual')</td>
                                                        <td>@lang('Beli di IGR')</td>
                                                        <td>@lang('Beli Tempat Lain')</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($produkmember as $pm)
                                                        <tr class="row_quisioner" id="q_{{ $pm->mpm_kodeprdcd }}">
                                                            <td class="text-left">{{ $pm->mpm_namaprdcd }}</td>
                                                            {{--                                                            <td>--}}
                                                            {{--                                                                <div class="custom-control custom-checkbox text-center">--}}
                                                            {{--                                                                    <input type="checkbox" class="custom-control-input" id="cb_q_{{ $pm->mpm_kodeprdcd }}_dijual">--}}
                                                            {{--                                                                    <label class="custom-control-label ml-1" for="cb_q_{{ $pm->mpm_kodeprdcd }}_dijual"></label>--}}
                                                            {{--                                                                </div>--}}
                                                            {{--                                                            </td>--}}
                                                            {{--                                                            <td>--}}
                                                            {{--                                                                <div class="custom-control custom-checkbox text-center">--}}
                                                            {{--                                                                    <input type="checkbox" class="custom-control-input" id="cb_q_{{ $pm->mpm_kodeprdcd }}_igr">--}}
                                                            {{--                                                                    <label class="custom-control-label ml-1" for="cb_q_{{ $pm->mpm_kodeprdcd }}_igr"></label>--}}
                                                            {{--                                                                </div>--}}
                                                            {{--                                                            </td>--}}
                                                            {{--                                                            <td>--}}
                                                            {{--                                                                <div class="custom-control custom-checkbox text-center">--}}
                                                            {{--                                                                    <input type="checkbox" class="custom-control-input" id="cb_q_{{ $pm->mpm_kodeprdcd }}_lain">--}}
                                                            {{--                                                                    <label class="custom-control-label ml-1" for="cb_q_{{ $pm->mpm_kodeprdcd }}_lain"></label>--}}
                                                            {{--                                                                </div>--}}
                                                            {{--                                                            </td>--}}
                                                            <td>
                                                                <input type="text" maxlength="1"
                                                                       class="quisioner dijual form-control text-center">
                                                            </td>
                                                            <td>
                                                                <input type="text" maxlength="1"
                                                                       class="quisioner beli-igr form-control text-center">
                                                            </td>
                                                            <td>
                                                                <input type="text" maxlength="1"
                                                                       class="quisioner beli-lain form-control text-center">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group row mb-0">
                                                    <div class="col-sm-5 text-left">
                                                        <label>@lang('Inputan Quisioner : [ Y / blank ]')</label>
                                                    </div>
                                                    <div class="col-sm-5"></div>
                                                    <button type="submit" id="btn-q-save"
                                                            class="btn btn-primary col-sm-2">SAVE
                                                    </button>
                                                </div>
                                            </div>
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

    <div class="modal fade" id="m_aktifnonaktif" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="form-group row text-center">
                            <label for="i_username" class="col-sm-12 text-center col-form-label">@lang('Masukkan username dan password untuk melanjutkan')</label>
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
                            <button id="btn-hapus-ok" class="btn col-sm-4 btn-info">OK</button>
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

        .custom-color li a {
            background-color: lightgrey;
        }

        .fix-height {
            height: 672px;
        }

        .wajib {
            color: red;
        }

        input {
            text-transform: uppercase;
        }


        input.tanggal {
            position: relative;
        }

        input.tanggal:before {
            position: absolute;
            top: 3px;
            left: 3px;
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

        .kosong {
            border-radius: 3px !important;
            outline: none !important;
            border-color: red !important;
            box-shadow: 0 0 10px red !important;
        }

        .segment {
            background-color: lightgrey;
        }

        .segment label {
            font-weight: bold !important;
            color: red !important;
        }

        .table-wrapper {
            overflow-y: scroll;
        }

        #table_quisioner tbody td {
            white-space: nowrap;
            vertical-align: middle;
        }
    </style>

    <script>

        let flagForFocus = false;

        var approvalMode;
        var isApproved;
        var arrjenissuboutlet = [];

        $(document).ready(function () {
            getLovKodepos('');
            getLovMember('');
            $('#table_lov_jenismember').DataTable();
            $('#table_lov_jenisoutlet').DataTable();
            $('#table_lov_group').DataTable();
            lov_member_select(1, false);

            initQuisionerArea();
        });

        function initQuisionerArea() {
            $('#m_quisioner').on('shown.bs.modal', function () {
                if (!$.fn.DataTable.isDataTable('#table_quisioner')) {
                    $('#table_quisioner').DataTable({
                        searching: false,
                        sort: false,
                        paging: false,
                        fixedHeader: true,
                        scrollY: true,
                        bInfo: false,
                    });
                }
                $('#table_quisioner tbody tr:nth-child(1) > td:nth-child(2) > input').select()
            });

            $('.dijual').on('change', function () {
                if (this.value == '') {
                    $(this).parent().parent().find('.beli-igr').val('');
                    $(this).parent().parent().find('.beli-lain').val('');
                }
            });

            $('.dijual').on('keypress', function (event) {
                if (event.which == 13) {
                    if (this.value == 'Y') {
                        $(this).parent().parent().find('.beli-igr').focus();
                    } else if (this.value == '') {
                        $(this).parent().parent().next().find('.dijual').focus();
                    } else {
                        swal({
                            title: 'Inputan [Y/ ]',
                            icon: 'warning',
                            timer: 750,
                        }).then(() => {
                            $(this).select();
                        });
                    }
                }
            });

            $('.beli-igr').on('keypress', function (event) {
                if (event.which == 13) {
                    $(this).parent().parent().find('.beli-lain').focus();
                }
            });

            $('.beli-lain').on('keypress', function (event) {
                if (event.which == 13) {
                    if ($(this).parent().parent().find('.dijual').val() == 'Y' && $(this).parent().parent().find('.beli-igr').val() == '' && $(this).parent().parent().find('.beli-lain').val() == '') {
                        swal({
                            title: "{{__('Kolom Beli di IGR atau Beli Tempat Lain harus diisi!')}}",
                            icon: 'warning',
                            timer: 1000
                        }).then(() => {
                            $(this).parent().parent().find('.beli-igr').focus();
                        });
                    } else $(this).parent().parent().next().find('.dijual').focus();
                }
            });
        }

        // Function for LOV
        function getLovMember(value) {
            let tableModalMember = $('#table_lov_member').DataTable({
                "ajax": {
                    'url': '{{ url()->current() }}/get-lov-member',
                    "data": {
                        'value': value
                    },
                },
                "columns": [
                    {data: 'cus_namamember', name: 'cus_namamember', width: '60%'},
                    {data: 'cus_kodemember', name: 'cus_kodemember', width: '40%'},
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
                columnDefs: [],
                "initComplete": function () {
                    $('#table_lov_member_filter input').val(value).select();
                }
            });

            $('#table_lov_member_filter input').val(value);

            $('#table_lov_member_filter input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModalMember.destroy();
                    getLovMember(val);
                }
            })
        }

        $(document).on('click', '.lov_member_select', function () {
            let member = $(this).find('td')[1]['innerHTML']

            lov_member_select(member, true)
        });

        $('#btn-modal-member').on('click', function () {
            setTimeout(function () {
                $('#table_lov_member_filter label input').focus();
            }, 1000);
        })

        function getLovKodepos(value) {
            let tableModalKodepos = $('#table_lov_kodepos').DataTable({
                "ajax": {
                    'url': '{{ url()->current() }}/get-lov-kodepos',
                    "data": {
                        'value': value
                    },
                },
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
                columnDefs: []
            });

            $('#table_lov_kodepos_filter input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModalKodepos.destroy();
                    getLovKodepos(val);
                }
            })
        }

        $(document).on('click', '.lov_kodepos_select', function () {
            let member = $(this).find('td')[1]['innerHTML']

            let pos_kode = $(this).find('td')[4]['innerHTML'];
            let pos_kecamatan = $(this).find('td')[1]['innerHTML'];
            let pos_kelurahan = $(this).find('td')[0]['innerHTML'];
            let pos_kabupaten = $(this).find('td')[2]['innerHTML'];

            lov_kodepos_select(pos_kode, pos_kecamatan, pos_kelurahan, pos_kabupaten);
        });

        // Function untuk auto focus ke search input ketika modal terbuka
        $('#m_kodeposHelp').on('shown.bs.modal', function () {
            setTimeout(function () {
                $('#table_lov_kodepos_filter label input').focus();
            }, 1000);
        })

        $('#m_jenismemberHelp').on('shown.bs.modal', function () {
            setTimeout(function () {
                $('#table_lov_jenismember_filter label input').focus();
            }, 1000);
        })

        $('#m_jenisoutletHelp').on('shown.bs.modal', function () {
            setTimeout(function () {
                $('#table_lov_jenisoutlet_filter label input').focus();
            }, 1000);
        })

        $('#m_groupHelp').on('shown.bs.modal', function () {
            setTimeout(function () {
                $('#table_lov_group_filter label input').focus();
            }, 1000);
        })

        //-- End Function for LOV


        month = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGU', 'SEP', 'OKT', 'NOV', 'DES'];
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


        $('#i_pendidikanX').hide();
        $('#c_metodekirimX').hide();
        $('#i_motor').hide();
        $('#i_motorX').hide();
        $('#i_mobil').hide();
        $('#i_mobilX').hide();

        // $('#btn-quisioner').hide();
        // $('#m_quisioner').modal('toggle');

        // $('#btn-p_identitas2').click();

        $(':input').on('keyup', function () {
            $(this).val(this.value.toUpperCase());
        });

        $('.diisi').on('change', function () {
            if ($(this).val() == null) {
                ok = false;
                $(this).addClass('kosong');
            } else if ($(this).val().length == 0) {
                ok = false;
                $(this).addClass('kosong');
            } else {
                $(this).removeClass('kosong');
            }
        });

        $(':input').prop('disabled', true);


        // $('#btn-rekam').prop('disabled',true);
        // $('#btn-aktif-nonaktif').prop('disabled',true);
        // $('#btn-hapus').prop('disabled',true);
        // $('#btn-export-crm').prop('disabled',true);

        $(':input').on('click', function () {
            $(this).select();
        });

        initial();

        //----------------------MULAI-------------------

        $('#cus_kodemember').on('keypress blur', function (event) {
            if (event.which == 13) {
                if (this.value.length == 0) {
                    swal({
                        title: "{{__('Isikan Nomor Anggota terlebih dahulu!')}}",
                        icon: "error",
                        timer: 750,
                        buttons: false,
                    }).then(function () {
                        swal.close();
                        $(':input').val('');
                        $(':input').prop('checked', false);
                    });
                } else {
                    lov_member_select(this.value);
                }
            }
        });

        $('#cus_namamember').on('keypress', function (event) {
            if (event.which == 13) {
                if (this.value.length > 0) {
                    $('#cus_noktp').select();
                }
            }
        });

        $('#cus_noktp').on('keypress', function (event) {
            if (event.which == 13) {
                if (this.value.length > 0) {
                    $('#cus_alamatmember1').select();
                }
            }
        });

        $('#cus_noktp').on('keyup', function (event) {
            let ktp = $('#cus_noktp').val().length;
            if (ktp < 16 || ktp > 16) {
                $('#message-error').show();
            } else {
                $('#message-error').hide();
            }
        })

        $('#cus_alamatmember1').on('keypress', function (event) {
            if (event.which == 13) {
                if (this.value.length > 0) {
                    $('#cus_alamatmember4').select();
                }
            }
        });

        $('#cus_alamatmember4').on('keypress', function (event) {
            if (event.which == 13) {
                if (this.value.length > 0 && this.value != member.cus_alamatmember8) {
                    field = 'ktp';
                    lov_kodepos_select('x', 'x', this.value.toUpperCase(), 'x');
                }
                $('#cus_alamatmember5').select();
            }
        });

        $('#cus_alamatmember4').on('blur', function (event) {
            if (this.value.length > 0 && this.value != member.cus_alamatmember8) {
                field = 'ktp';
                lov_kodepos_select('x', 'x', this.value.toUpperCase(), 'x');
            }
            $('#cus_alamatmember5').select();
        });

        $('#cus_alamatmember5').on('keypress', function (event) {
            if (event.which == 13) {
                if (this.value.length > 0) {
                    $('#cus_alamatmember8').select();
                }
            }
        });

        $('#cus_alamatmember8').on('keypress', function (event) {
            if (event.which == 13) {
                if (this.value.length > 0 && this.value != member.cus_alamatmember8) {
                    field = 'surat';
                    lov_kodepos_select('x', 'x', this.value.toUpperCase(), 'x');
                }
                $('#cus_tlpmember').select();
            }
        });

        $('#cus_alamatmember8').on('blur', function (event) {
            if (this.value.length > 0 && this.value != member.cus_alamatmember8) {
                field = 'surat';
                lov_kodepos_select('x', 'x', this.value.toUpperCase(), 'x');
            }
            $('#cus_tlpmember').select();
        });

        $('#cus_tlpmember').on('keypress', function (event) {
            if (event.which == 13) {
                if (this.value.length > 0) {
                    $('#crm_tmptlahir').select();
                    // $('#cus_hpmember').select();
                }
            }
        });

        $('#cus_hpmember').on('keypress', function (event) {
            if (event.which == 13) {
                if (this.value.length > 0) {
                    $('#crm_tmptlahir').select();
                }
            }
        });

        $('#crm_tmptlahir').on('keypress', function (event) {
            if (event.which == 13) {
                if (this.value.length > 0) {
                    $('#cus_tgllahir').select();
                }
            }
        });

        $('#cus_tgllahir').on('change', function () {
            $('#cus_jenismember').select();
        });

        $('#cus_tgllahir').on('keypress', function (event) {
            if (event.which == 13) {
                $('#cus_jenismember').select();
            }
        });

        $('#cus_jenismember').on('keypress', function (event) {
            if (event.which == 13) {
                found = false;
                if (this.value == '') {
                    $('#cus_jenismember').val(arrjenismember[0].jm_kode);
                    $('#i_jeniscustomer2').val(arrjenismember[0].jm_keterangan);
                    $('#cus_kodeoutlet').select();
                    found = true;
                } else {
                    for (i = 0; i < arrjenismember.length; i++) {
                        if (this.value == arrjenismember[i].jm_kode) {
                            found = true;
                            $('#cus_jenismember').val(arrjenismember[i].jm_kode);
                            $('#i_jeniscustomer2').val(arrjenismember[i].jm_keterangan);
                            $('#cus_kodeoutlet').select();
                            break;
                        }
                    }
                }
                if (!found) {
                    swal({
                        title: "{{__('Jenis Member Tidak Ditemukan')}}",
                        icon: "error"
                    }).then(function () {
                        swal.close();
                        $('#cus_jenismember').select();
                    });
                } else {
                    $('#cus_kodeoutlet').select();
                }
            }
        });

        $('#cus_kodeoutlet').on('change', function () {
            $('#cus_kodesuboutlet').val('');
            $('#i_suboutlet2').val('');

            if (this.value == '6') {
                $('#cus_kodesuboutlet').prop('disabled', true);
                $('#btn-modal-suboutlet').prop('disabled', true);
            } else {
                $('#cus_kodesuboutlet').prop('disabled', false);
                $('#btn-modal-suboutlet').prop('disabled', false);
            }
        });

        $('#cus_kodeoutlet').on('keypress', function (event) {
            if (event.which == 13) {
                found = false;

                for (i = 0; i < arrjenisoutlet.length; i++) {
                    if (this.value == arrjenisoutlet[i].out_kodeoutlet) {
                        found = true;
                        $('#cus_kodeoutlet').val(arrjenisoutlet[i].out_kodeoutlet);
                        $('#i_jenisoutlet2').val(arrjenisoutlet[i].out_namaoutlet);
                        $('#cus_jarak').select();
                        break;
                    }
                }
                if (!found) {
                    swal({
                        title: "{{__('Jenis Outlet Tidak Ditemukan')}}",
                        icon: "error",
                        closeModal: false
                    }).then(function () {
                        swal.close();
                        $('#cus_kodeoutlet').select();
                    });
                } else {
                    $('#cus_jarak').select();
                }
            }
        });

        $('#cus_jarak').on('keypress', function (event) {
            if (event.which == 13) {
                if ($('#cus_kodeoutlet').val() == 6) {
                    $('#cus_flagpkp').select();
                } else $('#cus_kodesuboutlet').select();
            }
        });

        $('#cus_kodesuboutlet').on('keypress', function (event) {
            if (event.which == 13) {
                found = false;

                for (i = 0; i < arrjenissuboutlet.length; i++) {
                    if (this.value == arrjenissuboutlet[i].sub_kodesuboutlet) {
                        found = true;
                        $('#cus_kodesuboutlet').val(arrjenissuboutlet[i].sub_kodesuboutlet);
                        $('#i_suboutlet2').val(arrjenissuboutlet[i].sub_namasuboutlet);

                        $('#cus_flagpkp').select();
                        break;
                    }
                }

                if (!found && this.value != '') {
                    swal({
                        title: "{{__('Jenis Sub Outlet Tidak Ditemukan')}}",
                        icon: "error",
                        closeModal: false
                    }).then(function () {
                        $('#cus_kodesuboutlet').select();
                    });
                } else {
                    $('#cus_flagpkp').select();
                }
            }
        });

        $('#cus_flagpkp').on('keypress', function (event) {
            if (event.which == 13) {
                this.value = this.value.toUpperCase();
                if (this.value != 'Y' && this.value != 'T' && this.value != '') {
                    swal({
                        title: "{{__('Pastikan inputan hanya berupa Y atau T')}}",
                        icon: "error",
                        closeModal: false
                    }).then(function () {
                        swal.close();
                        $('#cus_flagpkp').select();
                    });
                } else {
                    $('#cus_npwp').select();
                }
            }
        });

        $('#cus_npwp').on('keypress', function (event) {
            if (event.which == 13) {
                $('#cus_flagkredit').select();
            }
        });

        $('#cus_flagkredit').on('keypress', function (event) {
            if (event.which == 13) {
                this.value = this.value.toUpperCase();
                if (this.value != 'Y' && this.value != 'T' && this.value != '') {
                    swal({
                        title: "{{__('Pastikan inputan hanya berupa Y atau T!')}}",
                        icon: "error",
                        closeModal: false
                    }).then(function () {
                        swal.close();
                        $('#cus_flagkredit').select();
                    });
                } else {
                    if (this.value == 'T') {
                        isApproved = true;
                        $('#cus_creditlimit').val('').prop('disabled', true);
                        // $('#cus_top').prop('disabled', false);
                        // $('#cus_top').select();
                        $('#cus_nosalesman').select();
                    } else if(this.value == 'Y'){
                        isApproved = false;
                        $('#cus_creditlimit').prop('disabled', false).val('0').select();
                    }
                    else if(this.value == ''){
                        isApproved = false;
                        $('#cus_nosalesman').select();
                    }
                }
            }
        });

        $('#cus_creditlimit').on('keypress', function (event) {
            if (event.which == 13) {
                if (this.value < 0) {
                    swal({
                        title: "{{__('Pastikan nilai limit tidak kurang dari nol!')}}",
                        icon: "error",
                        closeModal: false
                    }).then(function () {
                        swal.close();
                        $('#cus_creditlimit').select();
                    });
                } else if ($('#cus_flagkredit').val() == 'Y' && this.value != member.cus_creditlimit) {
                    $('#m_aktifnonaktif').modal('show');

                    approvalMode = 'kredit';
                    isApproved = false;

                    $('#btn-aktifnonaktif-ok').show();
                    $('#btn-aktifnonaktif-ok').attr('disabled', false);
                    $('#btn-hapus-ok').hide();
                    $('#btn-hapus-ok').attr('disabled', true);
                } else {
                    $('#cus_top').select();
                }
            }
        });

        $('#cus_top').on('keypress', function (event) {
            if (event.which == 13) {
                if (this.value < 0) {
                    swal({
                        title: "{{__('Pastikan nilai TOP tidak kurang dari nol!')}}",
                        icon: "error",
                        closeModal: false
                    }).then(function () {
                        swal.close();
                        $('#cus_creditlimit').select();
                    });
                } else {
                    $('#cus_nosalesman').select();
                }
            }
        });

        $('#cus_nosalesman').on('keypress', function (event) {
            if (event.which == 13) {

                $('#cus_flagmemberkhusus').select();
            }
        });

        $('#cus_flagmemberkhusus').on('keypress', function (event) {
            if (event.which == 13) {

                $('#cus_flagkirimsms').select();
            }
        });

        $('#cus_flagkirimsms').on('keypress', function (event) {
            if (event.which == 13) {

                $('#btn-p_identitas2').click();
                $('#grp_group').select();
            }
        });

        $('#grp_group').on('keypress', function (event) {
            if (event.which == 13) {
                if (this.value == '') {
                    $('#m_groupHelp').modal('toggle');
                } else {
                    if ($('#cus_flagmemberkhusus').val() != 'Y' && this.value != 'BIRU') {
                        swal({
                            title: "{{__('Group harus diisi BIRU karena bukan member khusus')}}",
                            icon: "error",
                            closeModal: false
                        }).then(function () {
                            swal.close();
                            $('#grp_group').select();
                            $('#grp_group').val('');
                            $('#grp_subgroup').val('');
                            $('#grp_kategori').val('');
                            $('#grp_subkategori').val('');
                        });
                    } else {
                        lov_group_select($(this).val());
                    }
                }
            }
        });

        $('#cb_jenisanggotaR').on('keydown', function (event) {
            if (event.which == 13) {
                $(this).prop('checked', true);
                $('#cb_jeniskelaminL').focus();
            } else if (event.which == 39) {
                $('#cb_jenisanggotaK').focus();
            }
        });

        $('#cb_jenisanggotaK').on('keydown', function (event) {
            if (event.which == 13) {
                $(this).prop('checked', true);
                $('#cb_jeniskelaminL').focus();
            } else if (event.which == 37) {
                $('#cb_jenisanggotaR').focus();
            }
        });

        $('#cb_jenisanggotaR').on('change', function () {
            if ($('#cb_jenisanggotaR').is(':checked')) {
                $('#cb_jenisanggotaK').prop('checked', false);
            }
        });

        $('#cb_jenisanggotaK').on('change', function () {
            if ($('#cb_jenisanggotaK').is(':checked')) {
                $('#cb_jenisanggotaR').prop('checked', false);
            }
        });

        $('#cb_jeniskelaminL').on('keydown', function (event) {
            if (event.which == 13) {
                $(this).prop('checked', true);
                $('#cb_jeniskelaminP').prop('checked', false);
                $('#crm_pic1').select();
            } else if (event.which == 39) {
                $('#cb_jeniskelaminP').focus();
            }
        });

        $('#cb_jeniskelaminP').on('keydown', function (event) {
            if (event.which == 13) {
                $(this).prop('checked', true);
                $('#cb_jeniskelaminL').prop('checked', false);
                $('#crm_pic1').select();
            } else if (event.which == 37) {
                $('#cb_jeniskelaminL').focus();
            }
        });

        $('#cb_jeniskelaminL').on('change', function () {
            if ($('#cb_jeniskelaminL').is(':checked')) {
                $('#cb_jeniskelaminP').prop('checked', false);
            }
        });

        $('#cb_jeniskelaminP').on('change', function () {
            if ($('#cb_jeniskelaminP').is(':checked')) {
                $('#cb_jeniskelaminL').prop('checked', false);
            }
        });

        $('#crm_pic1').on('keydown', function (event) {
            if (event.which == 13) {
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

        $('#crm_pic1').on('blur', function () {
            if ($(this).val().length == 0) {
                $('#crm_nohppic1').val('');
                $('#crm_nohppic1').prop('disabled', true);
            } else {
                $('#crm_nohppic1').prop('disabled', false);
            }
        });

        $('#crm_nohppic1').on('keydown', function (event) {
            if (event.which == 13) {
                $('#crm_pic2').select();
            }
        });

        $('#crm_pic2').on('keydown', function (event) {
            if (event.which == 13) {
                if (this.value.length > 0) {
                    $('#crm_nohppic2').prop('disabled', false);
                    $('#crm_nohppic2').select();
                } else {
                    $('#crm_nohppic2').prop('disabled', true);
                    $('#crm_email').select();
                }
            }
        });

        $('#crm_pic2').on('blur', function () {
            if ($(this).val().length == 0) {
                $('#crm_nohppic2').val('');
                $('#crm_nohppic2').prop('disabled', true);
            } else {
                $('#crm_nohppic2').prop('disabled', false);
            }
        });

        $('#crm_nohppic2').on('keydown', function (event) {
            if (event.which == 13) {
                $('#crm_email').select();
            }
        });

        $('#crm_email').on('keydown', function (event) {
            if (event.which == 13) { //&& this.value.length > 0){
                $('#crm_agama').focus();
            }
        });

        $('#crm_agama').on('keydown', function (event) {
            if (this.value == null) {
                swal({
                    title: "{{__('Agama harus diisi!')}}",
                    icon: "error",
                    closeModal: false
                }).then(function () {
                    swal.close();
                    $('#crm_agama').select();
                });
            } else {
                if (event.which == 9) {
                    event.preventDefault();
                    $('#crm_pekerjaan').focus();
                } else if (event.which == 13)
                    $('#crm_pekerjaan').focus();
            }
        });

        $('#crm_pekerjaan').on('keydown', function (event) {
            if (event.which == 13) {
                $('#crm_namapasangan').select();
            }
        });

        $('#crm_namapasangan').on('keydown', function (event) {
            if (event.which == 13) {
                $('#crm_tgllhrpasangan').select();
            }
        });

        $('#crm_tgllhrpasangan').on('keydown', function (event) {
            if (event.which == 13) {
                if (this.value.length > 0) {
                    found = checkDate(this.value);

                    if (!found) {
                        swal({
                            title: "{{__('Format Tanggal Salah')}}",
                            icon: "error",
                            closeModal: false
                        }).then(function () {
                            swal.close();
                            $('#crm_tgllhrpasangan').select();
                        });
                    } else {
                        $('#crm_jmlanak').select();
                    }
                } else {
                    $('#crm_jmlanak').select();
                }
            }
        });

        $('#crm_jmlanak').on('keydown', function (event) {
            if (event.which == 13) {
                if (this.value.length > 0 && this.value < 0) {
                    swal({
                        title: "{{__('Jumlah anak tidak boleh kurang dari nol!')}}",
                        icon: "error",
                        closeModal: false
                    }).then(function () {
                        swal.close();
                        $('#crm_jmlanak').select();
                    });
                } else {
                    $('#i_pendidikan').focus();
                }
            }
        });

        $('#i_pendidikan').on('keydown', function (event) {
            if (event.which == 13) {
                $('#crm_nofax').select();
            }
        });

        $('#i_pendidikan').on('change', function () {
            if (this.value == 'X') {
                $('#i_pendidikanX').val('');
                $('#i_pendidikanX').show();
            } else {
                $('#i_pendidikanX').val('');
                $('#i_pendidikanX').hide();
            }
        });

        $('#crm_nofax').on('keydown', function (event) {
            if (event.which == 13) {
                $('#cb_internetY').focus();
            }
        });

        $('#cb_internetY').on('keydown', function (event) {
            if (event.which == 13) {
                $(this).click();
                $('#cb_internetT').prop('checked', false);
                $('#crm_tipehp').focus();
            } else if (event.which == 39) {
                $('#cb_internetT').focus();
            }
        });

        $('#cb_internetT').on('keydown', function (event) {
            if (event.which == 13) {
                $(this).click();
                $('#cb_internetY').prop('checked', false);
                $('#crm_tipehp').focus();
            } else if (event.which == 37) {
                $('#cb_internetY').focus();
            }
        });

        $('#cb_internetY').on('change', function () {
            if ($('#cb_internetY').is(':checked')) {
                $('#cb_internetT').prop('checked', false);
            }
        });

        $('#cb_internetT').on('change', function () {
            if ($('#cb_internetT').is(':checked')) {
                $('#cb_internetY').prop('checked', false);
            }
        });

        /////////////////

        $('#crm_tipehp').on('keydown', function (event) {
            if (event.which == 13) {
                $('#crm_namabank').select();
            }
        });

        $('#crm_namabank').on('keydown', function (event) {
            if (event.which == 13 && this.value.length > 0) {
                $('#c_metodekirim').focus();
            }
        });

        $('#c_metodekirim').on('keydown', function (event) {
            event.preventDefault();
            if ((event.which == 13 || event.which == 9) && this.value != null) {
                if (this.value == 'X') {
                    $('#c_metodekirimX').focus();
                } else {
                    $("#btn-p_identitas3").click();
                }
            }
        });

        $('#c_metodekirim').on('change', function () {
            if (this.value == 'X') {
                $('#c_metodekirimX').val('');
                $('#c_metodekirimX').show();
            } else {
                $('#c_metodekirimX').val('');
                $('#c_metodekirimX').hide();
                $("#btn-p_identitas3").click();
            }
        });

        $('#c_metodekirimX').on('keydown', function (event) {
            if ((event.which == 13 || event.which == 9) && this.value != '') {
                $("#btn-p_identitas3").click();
            }
        });

        // $('#i_koordinat').on('keydown',function(event){
        //     if(event.which == 13){
        //         $('#btn-p_identitas3').click();
        //         $('#crm_alamatusaha4').select();
        //     }
        // });

        $("#btn-p_identitas3").click(function () {
            setTimeout(function () {
                $('#crm_alamatusaha1').select();
            }, 250);
        });

        $('#crm_alamatusaha1').on('keypress', function (event) {
            if (event.which == 13 && this.value.length > 0) {
                $('#crm_alamatusaha4').select();
            }
        });

        $('#crm_alamatusaha4').on('keypress', function (event) {
            if (event.which == 13) {
                if (this.value.length > 0) {
                    field = 'usaha';
                    lov_kodepos_select('x', 'x', this.value.toUpperCase(), 'x');
                }
            }
        });

        $('#crm_alamatusaha4').on('blur', function (event) {
            if (this.value.length > 0) {
                field = 'usaha';
                lov_kodepos_select('x', 'x', this.value.toUpperCase(), 'x');
            }
        });

        $('#cb_jenisbangunanP').on('keydown', function (event) {
            if (event.which == 13) {
                $('#cb_jenisbangunanP').prop('checked', false);
                $('#cb_jenisbangunanS').prop('checked', false);
                $('#cb_jenisbangunanN').prop('checked', false);
                $('#crm_lamatmpt').select();
            } else if (event.which == 39) {
                $('#cb_jenisbangunanS').focus();
            }
        });

        $('#cb_jenisbangunanS').on('keydown', function (event) {
            if (event.which == 13) {
                $('#cb_jenisbangunanS').prop('checked', false);
                $('#cb_jenisbangunanP').prop('checked', false);
                $('#cb_jenisbangunanN').prop('checked', false);
                $('#crm_lamatmpt').select();
            } else if (event.which == 37) {
                $('#cb_jenisbangunanP').focus();
            } else if (event.which == 39) {
                $('#cb_jenisbangunanN').focus();
            }
        });

        $('#cb_jenisbangunanN').on('keydown', function (event) {
            if (event.which == 13) {
                $(this).click();
                $('#cb_jenisbangunanP').prop('checked', false);
                $('#cb_jenisbangunanS').prop('checked', false);
                $('#crm_lamatmpt').select();
            } else if (event.which == 37) {
                $('#cb_jenisbangunanS').focus();
            }
        });

        $('#cb_jenisbangunanP').on('change', function () {
            if ($('#cb_jenisbangunanP').is(':checked')) {
                $('#cb_jenisbangunanS').prop('checked', false);
                $('#cb_jenisbangunanN').prop('checked', false);
            }
        });

        $('#cb_jenisbangunanS').on('change', function () {
            if ($('#cb_jenisbangunanS').is(':checked')) {
                $('#cb_jenisbangunanP').prop('checked', false);
                $('#cb_jenisbangunanN').prop('checked', false);
            }
        });

        $('#cb_jenisbangunanN').on('change', function () {
            if ($('#cb_jenisbangunanN').is(':checked')) {
                $('#cb_jenisbangunanP').prop('checked', false);
                $('#cb_jenisbangunanS').prop('checked', false);
            }
        });

        $('#crm_lamatmpt').on('keydown', function (event) {
            if (event.which == 13 && this.value >= 0) {
                $('#cb_statusbangunanM').focus();
            }
        });

        $('#cb_statusbangunanM').on('keydown', function (event) {
            if (event.which == 13) {
                $(this).click();
                $('#cb_statusbangunanS').prop('checked', false);
                $('#crm_kreditusaha').select();
            } else if (event.which == 39) {
                $('#cb_statusbangunanS').focus();
            }
        });

        $('#cb_statusbangunanS').on('keydown', function (event) {
            if (event.which == 13) {
                $(this).click();
                $('#cb_statusbangunanM').prop('checked', false);
                $('#crm_kreditusaha').select();
            } else if (event.which == 37) {
                $('#cb_statusbangunanM').focus();
            }
        });

        $('#cb_statusbangunanM').on('change', function () {
            if ($('#cb_statusbangunanM').is(':checked')) {
                $('#cb_statusbangunanS').prop('checked', false);
            }
        });

        $('#cb_statusbangunanS').on('change', function () {
            if ($('#cb_statusbangunanS').is(':checked')) {
                $('#cb_statusbangunanM').prop('checked', false);
            }
        });

        $('#crm_kreditusaha').on('keydown', function (event) {
            if (event.which == 13) {
                $('#crm_bankkredit').select();
            }
        });

        $('#crm_bankkredit').on('keydown', function (event) {
            if (event.which == 13) {
                $('#cb_jeniskendaraanMotor').focus();
            }
        });

        $('#cb_jeniskendaraanMotor').on('change', function () {
            if ($('#cb_jeniskendaraanMotor').is(':checked')) {
                $('#i_motor').val('...');
                $('#i_motor').show();
                $('#i_motor').focus();
            } else {
                $('#i_motor').val('...');
                $('#i_motor').hide();
                $('#i_motorX').val('');
                $('#i_motorX').hide();
            }
        });

        $('#cb_jeniskendaraanMotor').on('keydown', function (event) {
            if (event.which == 13) {
                $('#cb_jeniskendaraanMobil').focus();
            }
        });

        $('#i_motor').on('change', function () {
            if (this.value == 'X') {
                $('#i_motorX').val('');
                $('#i_motorX').show();
            } else {
                $('#i_motorX').val('');
                $('#i_motorX').hide();
            }
        });

        $('#i_motor').on('keypress', function (event) {
            event.preventDefault();
            if (event.which == 13) {
                $('#cb_jeniskendaraanMobil').focus();
            }
        });

        $('#i_motorX').on('keypress', function (event) {
            if (event.which == 13 && this.value.length > 0) {
                $('#cb_jeniskendaraanMobil').focus();
            }
        });

        $('#cb_jeniskendaraanMobil').on('change', function () {
            if ($('#cb_jeniskendaraanMobil').is(':checked')) {
                $('#i_mobil').val('...');
                $('#i_mobil').show();
                $('#i_mobil').focus();
            } else {
                $('#i_mobil').val('...');
                $('#i_mobil').hide();
                $('#i_mobilX').val('');
                $('#i_mobilX').hide();
            }
        });

        $('#cb_jeniskendaraanMobil').on('keydown', function (event) {
            if (event.which == 13) {
                $('#btn-p_hobby').click();
            }
        });

        $('#i_mobil').on('change', function () {
            if (this.value == 'X') {
                $('#i_mobilX').val('');
                $('#i_mobilX').show();
                $('#i_mobilX').focus();
            } else {
                $('#i_mobilX').val('');
                $('#i_mobilX').hide();
            }
        });

        $('#i_mobil').on('keypress', function (event) {
            event.preventDefault();
            if (event.which == 13) {
                $('#btn-p_hobby').click();
            }
        });

        $('#i_mobilX').on('keypress', function (event) {
            if (event.which == 13 && this.value.length > 0) {
                $('#btn-p_hobby').click();
            }
        });

        $('#btn-p_npwp').on('click', function () {
            $('#cus_flagbebasiuran').select();
        });

        $('#cus_flagbebasiuran').on('keypress', function (event) {
            if (event.which == 13) {
                if (this.value != 'Y' && this.value != '') {
                    swal({
                        title: "{{__('Pastikan inputan hanya berupa Y atau kosong')}}",
                        icon: "error",
                        closeModal: false
                    }).then(function () {
                        swal.close();
                        $('#cus_flagbebasiuran').select();
                    });
                } else {
                    $('#cus_alamatemail').select();
                }
            }
        });

        $('#cus_alamatemail').on('keypress', function (event) {
            if (event.which == 13) {
                $('#cus_flagblockingpengiriman').select();
            }
        });

        $('#cus_flagblockingpengiriman').on('keypress', function (event) {
            if (event.which == 13) {
                if (this.value != 'Y' && this.value != '') {
                    swal({
                        title: "{{__('Pastikan inputan hanya berupa Y atau kosong')}}",
                        icon: "error",
                        closeModal: false
                    }).then(function () {
                        swal.close();
                        $('#cus_flagblockingpengiriman').select();
                    });
                } else {
                    $('#cus_flaginstitusipemerintah').select();
                }
            }
        });

        $('#cus_flaginstitusipemerintah').on('keypress', function (event) {
            if (event.which == 13) {
                if (this.value != 'Y' && this.value != '') {
                    swal({
                        title: "{{__('Pastikan inputan hanya berupa Y atau kosong')}}",
                        icon: "error",
                        closeModal: false
                    }).then(function () {
                        swal.close();
                        $('#cus_flaginstitusipemerintah').select();
                    });
                } else {
                    $('#btn-p_fasilitasbank').click();
                }
            }
        });

        $('#search_lov_member').keypress(function (e) {
            if (e.which == 13) {
                if (this.value.length == 0) {
                    $('.invalid-feedback').hide();
                    $('#table_lov_member .not-found').remove();
                    $('#table_lov_member .row_lov').remove();
                    $('#table_lov_member').append(trlovmember);
                } else if (this.value.length >= 4) {
                    $('.invalid-feedback').hide();
                    $.ajax({
                        url: '{{ url()->current() }}/lov-member-search',
                        type: 'GET',
                        data: {"_token": "{{ csrf_token() }}", value: this.value.toUpperCase()},
                        beforeSend: function () {
                            $('#m_kodememberHelp').modal({backdrop: 'static', keyboard: false});
                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        },
                        success: function (response) {
                            $('#table_lov_member .row_lov').remove();
                            html = "";
                            if (response.length == 0) {
                                html = '<tr class="not-found"><td>@lang('Member tidak ditemukan')</td></tr>';
                                $('#table_lov_member').append(html);
                            } else {
                                for (i = 0; i < response.length; i++) {
                                    html = '<tr class="row_lov" onclick=lov_member_select("' + response[i].cus_kodemember + '",true)><td>' + response[i].cus_namamember + '</td><td>' + response[i].cus_kodemember + '</td></tr>';
                                    $('#table_lov_member').append(html);
                                }
                            }
                            $('#modal-loader').modal('hide');
                        },
                        complete: function () {
                            $('#m_kodememberHelp').modal({backdrop: 'static', keyboard: true});
                            $('#modal-loader').modal('hide');
                        }
                    });
                } else {
                    $('.invalid-feedback').show();
                }
            }
        });

        $('#btn-modal-ktp').on('click', function () {
            field = 'ktp';
        });

        $('#btn-modal-surat').on('click', function () {
            field = 'surat';
        });

        $('#btn-modal-usaha').on('click', function () {
            field = 'usaha';
        });

        $('#search_lov_kodepos').keypress(function (e) {
            if (e.which == 13) {
                if (this.value.length == 0) {
                    $('.invalid-feedback').hide();
                    $('#table_lov_kodepos .row_lov').remove();
                    $('#table_lov_kodepos').append(trlovkodepos);
                } else if (this.value.length >= 4) {
                    $('.invalid-feedback').hide();
                    $.ajax({
                        url: '{{ url()->current() }}/lov-kodepos-search',
                        type: 'GET',
                        data: {"_token": "{{ csrf_token() }}", value: this.value.toUpperCase()},
                        beforeSend: function () {
                            $('#m_kodeposHelp').modal({backdrop: 'static', keyboard: false});
                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        },
                        success: function (response) {
                            $('#table_lov_kodepos .row_lov').remove();
                            html = "";
                            for (i = 0; i < response.length; i++) {
                                html = '<tr class="row_lov" onclick="lov_kodepos_select(\'' + response[i].pos_kode + '\',\'' + response[i].pos_kecamatan + '\',\'' + response[i].pos_kelurahan + '\',\'' + response[i].pos_kabupaten + '\')"><td>' + response[i].pos_kelurahan + '</td><td>' + response[i].pos_kecamatan + '</td><td>' + response[i].pos_kabupaten + '</td><td>' + response[i].pos_propinsi + '</td><td>' + response[i].pos_kode + '</td></tr>';
                                $('#table_lov_kodepos').append(html);
                            }
                            $('#modal-loader').modal('hide');
                        },
                        complete: function () {
                            $('#m_kodeposHelp').modal({backdrop: 'static', keyboard: true});
                            $('#modal-loader').modal('hide');
                        }
                    });
                } else {
                    $('.invalid-feedback').show();
                }
            }
        });


        $("#cus_tgllahir").datepicker({
            "dateFormat": "dd/mm/yy"
        });

        $("#crm_tgllhrpasangan").datepicker({
            "dateFormat": "dd/mm/yy"
        });

        function initial() {
            $('#btn-p_identitas').click();
            $('.kosong').each(function () {
                $(this).removeClass('kosong');
            });

            $(':input').prop('checked', false);
            $('input[id^="cb_"]').each(function () {
                $(this).prop('disabled', true);
                $(this).prop('checked', false);
            });
            $(':input').prop('disabled', true);
            $(':input').val('');
            $('select').prop('disabled', true);

            $('button').each(function () {
                $(this).prop('disabled', true);
            });
            $('#btn-modal-member').prop('disabled', false);

            $('#search_lov_member').prop('disabled', false);
            $('#cus_kodemember').prop('disabled', false);
            $('#cus_kodemember').focus();
        }

        function ready() {
            initial();

            $(':input').prop('disabled', false);
            $('input[id^="cb_"]').each(function () {
                $(this).prop('disabled', false);
            });
            $('select').prop('disabled', false);

            $('button').each(function () {
                $(this).prop('disabled', false);
            });

            $('#i_statusmember').prop('disabled', true);
            $('#i_updateterakhir').prop('disabled', true);
            $('#cus_alamatmember3').prop('disabled', true);
            $('#i_kecamatanktp').prop('disabled', true);
            $('#cus_alamatmember2').prop('disabled', true);
            $('#cus_alamatmember7').prop('disabled', true);
            $('#i_kecamatansurat').prop('disabled', true);
            $('#cus_alamatmember6').prop('disabled', true);
            $('#crm_alamatusaha3').prop('disabled', true);
            $('#pos_kecamatan').prop('disabled', true);
            $('#crm_alamatusaha2').prop('disabled', true);
            $('#i_jeniscustomer2').prop('disabled', true);
            $('#i_jenisoutlet2').prop('disabled', true);
            $('#cus_kodesuboutlet').prop('disabled', true);
            $('#i_suboutlet2').prop('disabled', true);
            $('#grp_subgroup').prop('disabled', true);
            $('#grp_kategori').prop('disabled', true);
            $('#grp_subkategori').prop('disabled', true);
            $('#crm_nohppic1').prop('disabled', true);
            $('#crm_nohppic2').prop('disabled', true);
            $('#cus_tglmulai').prop('disabled', true);
            $('#cus_tglregistrasi').prop('disabled', true);
            $('#cus_nokartumember').prop('disabled', true);
            $('#i_alamatnpwp').prop('disabled', true);
            $('#i_kelurahannpwp').prop('disabled', true);
            $('#i_kodeposnpwp').prop('disabled', true);
            $('#i_kotanpwp').prop('disabled', true);

            $('input[id$="_ket"]').each(function () {
                $(this).prop('disabled', true);
            });
        }

        function view_sub_outlet() {
            $('#m_suboutletHelp').modal('show');
        }

        $(document).on('click', '.row_lov_suboutlet', function () {
            let kode = $(this).find('td')[0]['innerHTML']
            let nama = $(this).find('td')[1]['innerHTML']

            $('#cus_kodesuboutlet').val(kode);
            $('#i_suboutlet2').val(nama);

            $('#m_suboutletHelp').modal('hide');
        })

        function cek_field_wajib() {
            $('.kosong').removeClass('kosong');

            ok = true;

            //Validasi KTP
            let ktp = $('#cus_noktp').val().length;
            if (ktp < 16 || ktp > 16) {
                $('#message-error').show();
                $('#cus_noktp').focus();
                $('#cus_noktp').addClass('kosong');
                return false;
            } else {
                $('#message-error').hide();
            }


            $('.diisi').each(function () {
                if ($(this).val() != null && $(this).val().length > 0) {
                    $(this).removeClass('kosong');
                } else {
                    if ($(this).hasClass('id3') && $('#cus_flagmemberkhusus').val() !== 'Y') {
                        $(this).removeClass('kosong');
                    } else {
                        $(this).addClass('kosong');
                        ok = false;
                    }
                }
            });

            if (ok) {
                lastId = null;
                id = null;
                cb = '!ok';

                isCbValid = true;

                total = $('.diisi_cb').length;

                $('.diisi_cb').each(function (index) {
                    if ($(this).is(':visible')) {
                        if ($(this).hasClass('id3') && $('#cus_flagmemberkhusus').val() !== 'Y') {
                            // console.log(id);
                            return false;
                        } else if (id != $(this).attr('id').substr(0, 11)) {
                            if (!isCbValid && id != null) {
                                console.log(id);
                                lastId.parent().parent().parent().addClass('kosong');
                                return false;
                            }

                            lastId = $(this);
                            id = $(this).attr('id').substr(0, 11);

                            isCbValid = $(this).is(':checked');
                        } else {
                            if (!isCbValid) {
                                isCbValid = $(this).is(':checked');
                            }
                        }
                    }

                    if (index === total - 1 && !isCbValid) {
                        console.log(id);
                        lastId.parent().parent().parent().addClass('kosong');
                    }
                });
                return isCbValid;
            }
        }

        function lov_member_select(value, load) {
            $.ajax({
                url: '{{ url()->current() }}/lov-member-select',
                type: 'GET',
                data: {"_token": "{{ csrf_token() }}", value: value},
                beforeSend: function () {
                    if (load) {
                        $('#m_kodememberHelp').modal({backdrop: 'static', keyboard: false});
                    }
                    $('#m_kodememberHelp').modal('hide');
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    if (response == 'not-found') {
                        swal({
                            title: "{{__('Data Member Tidak Ditemukan!')}}",
                            text: "{{__('Cek kembali kode member')}}",
                            icon: "error",
                            buttons: false,
                            timer: 1250
                        });

                        initial();
                        $('#cus_kodemember').val(value);
                    } else {
                        $('#modal-loader').modal('hide');
                        // swal({
                        //     title: 'Data ditemukan!',
                        //     icon: 'success'
                        // }).then(function(){
                        //     $('#modal-loader').modal('hide');
                        // })

                        ready();

                        arrjenissuboutlet = response['arrsuboutlet'];

                        for (let i = 0; i < arrjenissuboutlet.length; i++) {
                            $('#tbody_table_lov_suboutlet').append(`
                                <tr class="row_lov row_lov_suboutlet">
                                    <td>${arrjenissuboutlet[i].sub_kodesuboutlet}</td>
                                    <td>${arrjenissuboutlet[i].sub_namasuboutlet}</td>
                                </tr>
                            `);
                        }

                        member = response['member'];
                        ktp = response['ktp'];
                        surat = response['surat'];
                        usaha = response['usaha'];
                        jenismember = response['jenismember'];
                        outlet = response['outlet'];
                        suboutlet = response['suboutlet'];
                        group = response['group'];
                        npwp = response['npwp'];

                        skipKTP = false;

                        if (ktp == null) {
                            swal({
                                title: "{{__('Kecamatan tidak terdaftar di database!')}}",
                                icon: "error"
                            });

                            skipKTP = true;
                        }

                        $(':input').val('');
                        $(':input').prop('checked', false);

                        $('#cus_kodemember').val(member.cus_kodemember);
                        $('#cus_namamember').val(member.cus_namamember);
                        if (member.cus_recordid == '1') {
                            $('#i_statusmember').val('NON-AKTIF');
                        } else $('#i_statusmember').val('AKTIF');

                        if (member.crm_idsegment == '6')
                            $('#segment').show();
                        else $('#segment').hide();

                        $('#i_updateterakhir').val(member.cus_modify_by == null ? '' : member.cus_modify_by + ' ' + member.cus_modify_dt);

                        if (member.cus_flagmemberkhusus == 'Y' && member.cus_recordid == null) {
                            $('#btn-quisioner').show();
                            $('.d-flag-ina').show();
                        } else {
                            $('#btn-quisioner').hide();
                            $('.d-flag-ina').hide();
                        }

                        //######################################################### panel identitas 1 ######################################################################
                        $('#cus_noktp').val(member.cus_noktp);
                        if (member.cus_noktp == null || member.cus_noktp.length != 16)
                            $('#message-error').show();
                        else $('#message-error').hide();
                        $('#cus_alamatmember1').val(member.cus_alamatmember1);
                        $('#cus_alamatmember4').val(member.cus_alamatmember4);

                        if (!skipKTP) {
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
                        if (member.cus_namamember == 'NEW') {
                            $('#cus_hpmember').val(member.cus_hpmember).prop('disabled', false);
                            $('#cus_flagmemberkhusus').prop('disabled', false);
                        } else {
                            $('#cus_hpmember').val(member.cus_hpmember).prop('disabled', true);
                            $('#cus_flagmemberkhusus').prop('disabled', true);
                        }
                        $('#crm_tmptlahir').val(member.crm_tmptlahir);
                        $('#cus_tgllahir').val(formatDate(member.cus_tgllahir));
                        $('#cus_jenismember').val(jenismember.jm_kode);
                        $('#i_jeniscustomer2').val(jenismember.jm_keterangan);
                        $('#cus_kodeoutlet').val(outlet == null ? '' : outlet.out_kodeoutlet);
                        $('#i_jenisoutlet2').val(outlet == null ? '' : outlet.out_namaoutlet);
                        if ($('#cus_kodeoutlet').val() == 6) {
                            $('#cus_kodesuboutlet').val('').prop('disabled', true);
                            $('#i_suboutlet2').val('').prop('disabled', true);
                        } else {
                            $('#cus_kodesuboutlet').val(suboutlet ? suboutlet.sub_kodesuboutlet : '').prop('disabled', false);
                            $('#i_suboutlet2').val(suboutlet ? suboutlet.sub_namasuboutlet : '');
                        }
                        $('#cus_jarak').val(member.cus_jarak);
                        $('#cus_flagpkp').val(member.cus_flagpkp);
                        $('#cus_npwp').val(member.cus_npwp);
                        $('#cus_flagkredit').val(member.cus_flagkredit);
                        if (member.cus_flagkredit == 'Y') {
                            $('#cus_creditlimit').prop('disabled', false);
                            $('#cus_top').prop('disabled', false);
                        }else{
                            $('#cus_creditlimit').prop('disabled', true);
                            $('#cus_top').prop('disabled', true);
                        }
                        $('#cus_creditlimit').val(member.cus_creditlimit);
                        $('#cus_top').val(member.cus_top);
                        $('#cus_nosalesman').val(member.cus_nosalesman);
                        $('#cus_flagmemberkhusus').val(member.cus_flagmemberkhusus);
                        $('#cus_flagkirimsms').val(member.cus_flagkirimsms);

                        $('#cb_flag_ina').prop('checked', member.cus_flag_ina == 'Y' ? true : false);

                        //######################################################### panel identitas 2 ######################################################################
                        if (group != null) {
                            idgroupkat = group.grp_idgroupkat;
                            $('#grp_group').val(group.grp_group);
                            $('#grp_subgroup').val(group.grp_subgroup);
                            $('#grp_kategori').val(group.grp_kategori);
                            $('#grp_subkategori').val(group.grp_subkategori);
                        }
                        if (member.crm_jenisanggota == 'R') {
                            $('#cb_jenisanggotaR').prop('checked', true);
                        } else if (member.crm_jenisanggota == 'K') {
                            $('#cb_jenisanggotaK').prop('checked', true);
                        }
                        if (member.crm_jeniskelamin == 'L') {
                            $('#cb_jeniskelaminL').prop('checked', true);
                        } else if (member.crm_jeniskelamin == 'P') {
                            $('#cb_jeniskelaminP').prop('checked', true);
                        }
                        $('#crm_pic1').val(member.crm_pic1);
                        $('#crm_nohppic1').val(member.crm_nohppic1);
                        $('#crm_pic2').val(member.crm_pic2);
                        if ($('#crm_nohppic2').val().length > 0)
                            $('#crm_nohppic2').prop('disabled', false);
                        $('#crm_nohppic2').val(member.crm_nohppic2);
                        $('#crm_email').val(member.crm_email);
                        $('#crm_agama').val(to_uppercase(member.crm_agama));

                        if (member.crm_group == 'BIRU')
                            $('.crm-pekerjaan').show();
                        else $('.crm-pekerjaan').hide();
                        $('#crm_pekerjaan').val(member.crm_pekerjaan);

                        $('#crm_namapasangan').val(member.crm_namapasangan);
                        $('#crm_tgllhrpasangan').val(formatDate(member.crm_tgllhrpasangan));
                        $('#crm_jmlanak').val(member.crm_jmlanak);
                        if (member.crm_pendidikanakhir != '') {
                            $('#i_pendidikan').val(member.crm_pendidikanakhir);
                            $('#i_pendidikanX').hide();
                        } else {
                            $('#i_pendidikan').val('X');
                            $('#i_pendidikanX').show();
                        }
                        if ($('#i_pendidikan').val() == null) {
                            $('#i_pendidikan').val('X');
                            $('#i_pendidikanX').show();
                        }
                        $('#crm_nofax').val(member.crm_nofax);
                        if (member.crm_internet == 'Y') {
                            $('#cb_internetY').prop('checked', true);
                        } else if (member.crm_internet == 'T') {
                            $('#cb_internetT').prop('checked', true);
                        }
                        $('#crm_tipehp').val(member.crm_tipehp);
                        $('#crm_namabank').val(member.crm_namabank);
                        $('#c_metodekirim').val(member.crm_metodekirim);
                        if ($('#c_metodekirim').val() == null) {
                            $('#c_metodekirim').val('X');
                            $('#c_metodekirimX').show();
                            $('#c_metodekirimX').val(member.crm_metodekirim);
                        } else $('#c_metodekirimX').hide();
                        $('#i_koordinat').val(member.crm_koordinat);
                        $('#i_koordinat').attr('disabled', true);

                        //#########################################################panel identitas 3######################################################################
                        $('#crm_alamatusaha1').val(member.crm_alamatusaha1);
                        $('#crm_alamatusaha4').val(member.crm_alamatusaha4);
                        $('#pos_kecamatan').val(usaha.pos_kecamatan);
                        $('#crm_alamatusaha3').val(usaha.pos_kode);
                        $('#crm_alamatusaha2').val(member.crm_alamatusaha2);

                        if (member.crm_jenisbangunan != '')
                            $('#cb_jenisbangunan' + member.crm_jenisbangunan).prop('checked', true);
                        $('#crm_lamatmpt').val(member.crm_lamatmpt);
                        if (member.crm_statusbangunan != '')
                            $('#cb_statusbangunan' + member.crm_statusbangunan).prop('checked', true);
                        $('#crm_kreditusaha').val(member.crm_kreditusaha);
                        $('#crm_bankkredit').val(member.crm_bankkredit);
                        if (member.crm_motor != '' && member.crm_motor != null) {
                            $('#i_motor').val(member.crm_motor);
                            $('#cb_jeniskendaraanMotor').prop('checked', true);
                            if ($('#i_motor').val() != null) {
                                $('#i_motor').show();
                                $('#i_motorX').hide();
                            } else {
                                $('#i_motor').val('X');
                                $('#i_motor').show();
                                $('#i_motorX').val(member.crm_motor);
                                $('#i_motorX').show();
                            }
                        } else {
                            $('#i_motor').hide();
                            $('#i_motorX').hide();
                        }
                        if (member.crm_mobil != '' && member.crm_mobil != null) {
                            $('#i_mobil').val(member.crm_mobil);
                            $('#cb_jeniskendaraanMobil').prop('checked', true);
                            if ($('#i_mobil').val() != null) {
                                $('#i_mobil').show();
                                $('#i_mobilX').hide();
                            } else {
                                $('#i_mobil').val('X');
                                $('#i_mobil').show();
                                $('#i_mobilX').val(member.crm_mobil);
                                $('#i_mobilX').show();
                            }
                        } else {
                            $('#i_mobil').hide();
                            $('#i_mobilX').hide();
                        }

                        //######################################################### panel hobby ######################################################################
                        for (i = 0; i < response['hobbymember'].length; i++) {
                            $('#cb_h' + response['hobbymember'][i].dhb_kodehobby).prop('checked', true);
                            if (response['hobbymember'][i].dhb_keterangan != null || response['hobbymember'][i].dhb_keterangan != '') {
                                $('#cb_h' + response['hobbymember'][i].dhb_kodehobby + '_ket').val(response['hobbymember'][i].dhb_keterangan);
                                $('#cb_h' + response['hobbymember'][i].dhb_kodehobby + '_ket').prop('disabled', false);
                            } else {
                                $('#cb_h' + response['hobbymember'][i].dhb_kodehobby + '_ket').val('');
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

                        if (npwp != '' && npwp != null) {
                            $('#i_alamatnpwp').val(npwp.pwp_alamat);
                            $('#i_kelurahannpwp').val(npwp.pwp_kelurahan);
                            $('#i_kotanpwp').val(npwp.pwp_kota);
                            $('#i_kodeposnpwp').val(npwp.pwp_kodepos);
                        } else {
                            $('#i_alamatnpwp').val(member.cus_alamatmember1);
                            $('#i_kelurahannpwp').val(member.cus_alamatmember4);
                            $('#i_kotanpwp').val(member.cus_alamatmember2);
                            $('#i_kodeposnpwp').val(member.cus_alamatmember3);
                        }

                        //######################################################### panel bank ######################################################################
                        for (i = 0; i < response['bank'].length; i++) {
                            $('#cb_b' + response['bank'][i].cub_kodefasilitasbank).prop('checked', true);
                        }

                        quisioner = response['quisioner'];
                        for (i = 0; i < quisioner.length; i++) {
                            if (quisioner[i].fpm_flagjual == 'T')
                                jual = 'Y';
                            else jual = '';

                            if (quisioner[i].fpm_flagbeliigr == 'T')
                                beliigr = 'Y';
                            else beliigr = '';

                            if (quisioner[i].fpm_flagbelilain == 'T')
                                belilain = 'Y';
                            else belilain = '';

                            $('#q_' + quisioner[i].fpm_kodeprdcd).find('.dijual').val(jual);
                            $('#q_' + quisioner[i].fpm_kodeprdcd).find('.beli-igr').val(beliigr);
                            $('#q_' + quisioner[i].fpm_kodeprdcd).find('.beli-lain').val(belilain);
                        }
                    }
                    $('#modal-loader').modal('hide');
                }, error: function (err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0, 100));
                    alertError(err.statusText, err.responseJSON.message);
                },
                complete: function () {
                    if (load) {
                        if ($('#m_kodememberHelp').is(':visible')) {
                            $('#m_kodememberHelp').modal('toggle');
                            $('#search_lov_member').val('');
                            $('#table_lov_member .row_lov').remove();
                            $('#table_lov_member').append(trlovmember);
                            $('#m_kodememberHelp').modal({backdrop: 'static', keyboard: true});
                        }
                    }
                    $('#modal-loader').modal('hide');
                    $('#cus_noktp').select();

                    // if(flagForFocus == false) {
                    //     flagForFocus = true;
                    //     $('#cus_kodemember').select();
                    // }
                }
            });
        }

        function lov_kodepos_select(kode, kecamatan, kelurahan, kabupaten) {
            success = false;
            $.ajax({
                url: '{{ url()->current() }}/lov-kodepos-select',
                type: 'GET',
                data: {
                    "_token": "{{ csrf_token() }}",
                    kode: kode,
                    kecamatan: kecamatan,
                    kelurahan: kelurahan,
                    kabupaten: kabupaten
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                    $('#m_kodeposHelp').modal('hide');
                },
                success: function (response) {
                    if (response == 'not-found') {
                        swal({
                            title: "{{__('Kelurahan tidak terdaftar di database!')}}",
                            text: "{{__('Cek ulang inputan kelurahan')}}",
                            icon: "error",
                            buttons: false,
                            timer: 750
                        }).then(function () {
                            if (field == 'ktp') {
                                $('#cus_alamatmember2').val('');
                                $('#cus_alamatmember3').val('');
                                $('#cus_alamatmember4').val('');
                                $('#i_kecamatanktp').val('');
                                $('#cus_alamatmember4').select();
                            } else if (field == 'surat') {
                                $('#cus_alamatmember6').val('');
                                $('#cus_alamatmember7').val('');
                                $('#cus_alamatmember8').val('');
                                $('#i_kecamatansurat').val('');
                                $('#cus_alamatmember8').select();
                            } else if (field == 'usaha') {
                                $('#crm_alamatusaha2').val('');
                                $('#crm_alamatusaha3').val('');
                                $('#crm_alamatusaha4').val('');
                                $('#i_kecamatanusaha').val('');
                                $('#crm_alamatusaha4').select();
                            }
                        });
                        success = false;
                    } else {
                        success = true;

                        kode = response.pos_kode;
                        kecamatan = response.pos_kecamatan;
                        kelurahan = response.pos_kelurahan;
                        kabupaten = response.pos_kabupaten;

                        insert_detail_alamat(kelurahan, kecamatan, kode, kabupaten);
                    }
                    $('#modal-loader').modal('hide');
                },
                error: function (err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0, 100));
                    alertError(err.statusText, err.responseJSON.message);
                },
                complete: function () {
                    $('#modal-loader').modal('hide');
                    if ($('#m_kodeposHelp').is(':visible')) {
                        $('#m_kodeposHelp').modal('toggle');
                    }
                    if (success) {
                        if (field == 'ktp') {
                            $('#cus_alamatmember5').select();
                        } else if (field == 'surat') {
                            $('#cus_tlpmember').select();
                        } else if (field == 'usaha') {
                            $('#cb_jenisbangunanP').select();
                        }
                    }

                    $('.kosong').each(function () {
                        if ($(this).val() != null && $(this).val().length > 0) {
                            $(this).removeClass('kosong');
                        }
                    });
                }
            });
        }

        function insert_detail_alamat(kelurahan, kecamatan, kode, kabupaten) {
            if (field == 'ktp') {
                $('#cus_alamatmember4').val(kelurahan);
                $('#i_kecamatanktp').val(kecamatan);
                $('#cus_alamatmember3').val(kode);
                $('#cus_alamatmember2').val(kabupaten);

                if ($('#cus_alamatmember7').val() == '') {
                    $('#cus_alamatmember8').val(kelurahan);
                    $('#i_kecamatansurat').val(kecamatan);
                    $('#cus_alamatmember7').val(kode);
                    $('#cus_alamatmember6').val(kabupaten);
                }
            } else if (field == 'surat') {
                $('#cus_alamatmember8').val(kelurahan);
                $('#i_kecamatansurat').val(kecamatan);
                $('#cus_alamatmember7').val(kode);
                $('#cus_alamatmember6').val(kabupaten);
            } else if (field == 'usaha') {
                $('#crm_alamatusaha4').val(kelurahan);
                $('#pos_kecamatan').val(kecamatan);
                $('#crm_alamatusaha3').val(kode);
                $('#crm_alamatusaha2').val(kabupaten);
            }
        }

        function lov_jenismember_select(kode, keterangan) {
            $('#cus_jenismember').val(kode);
            $('#i_jeniscustomer2').val(keterangan);

            if ($('#m_jenismemberHelp').is(':visible')) {
                $('#m_jenismemberHelp').modal('toggle');
            }
        }

        function lov_jenisoutlet_select(kode, nama) {
            $('#cus_kodeoutlet').val(kode);
            $('#i_jenisoutlet2').val(nama);
            $('#cus_kodesuboutlet').val('');
            $('#i_suboutlet2').val('');

            if (kode == '6') {
                $('#cus_kodesuboutlet').prop('disabled', true);
                $('#btn-modal-suboutlet').prop('disabled', true);
            } else {
                $('#cus_kodesuboutlet').prop('disabled', false);
                $('#btn-modal-suboutlet').prop('disabled', false);

                $('#tbody_table_lov_suboutlet').children().remove();

                getLovSubOutlet();
            }

            $('#m_jenisoutletHelp').modal('hide');
        }

        function getLovSubOutlet() {
            $.ajax({
                url: '{{ url()->current() }}/lov-sub-outlet',
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    outlet: $('#cus_kodeoutlet').val()
                },
                beforeSend: () => {
                    // $('#modal-loader').modal('show');
                },
                success: function (result) {
                    $('#tbody_table_lov_suboutlet').children().remove();

                    if (result.length > 0) {
                        arrjenissuboutlet = result;

                        for (let i = 0; i < result.length; i++) {
                            $('#tbody_table_lov_suboutlet').append(`
                                <tr class="row_lov row_lov_suboutlet">
                                    <td>${result[i].sub_kodesuboutlet}</td>
                                    <td>${result[i].sub_namasuboutlet}</td>
                                </tr>
                            `);
                        }
                    } else {
                        $('#tbody_table_lov_suboutlet').append(`
                            <tr class="text-center">
                                <td>--</td>
                                <td>--</td>
                            </tr>
                        `);
                    }

                    console.log(result);

                },
                error: function (err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0, 100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            });
        }

        function check_hobby(event) {
            if ($('#' + event.target.id).is(':checked')) {
                $('#' + event.target.id + '_ket').prop('disabled', false);
            } else {
                $('#' + event.target.id + '_ket').val('');
                $('#' + event.target.id + '_ket').prop('disabled', true);
            }
        }

        function to_uppercase(value) {
            if (value == '' || value == null)
                return '';
            else return value.toUpperCase();
        }

        function lov_group_select(id) {
            for (i = 0; i < arrgroup.length; i++) {
                if (id.match(/([A-z])/g).length == id.length) {
                    if (id == arrgroup[i].grp_group) {
                        $('#grp_group').val(arrgroup[i].grp_group);
                        $('#grp_subgroup').val(arrgroup[i].grp_subgroup);
                        $('#grp_kategori').val(arrgroup[i].grp_kategori);
                        $('#grp_subkategori').val(arrgroup[i].grp_subkategori);
                        idgroupkat = arrgroup[i].grp_idgroupkat;
                        break;
                    }
                } else {
                    if (id == arrgroup[i].grp_idgroupkat) {
                        $('#grp_group').val(arrgroup[i].grp_group);
                        $('#grp_subgroup').val(arrgroup[i].grp_subgroup);
                        $('#grp_kategori').val(arrgroup[i].grp_kategori);
                        $('#grp_subkategori').val(arrgroup[i].grp_subkategori);
                        idgroupkat = arrgroup[i].grp_idgroupkat;
                        break;
                    }
                }
            }

            $('.diisi').each(function () {
                if ($(this).val() != null && $(this).val().length > 0) {
                    ok = false;
                    $(this).removeClass('kosong');
                }
            });

            if ($('#m_groupHelp').is(':visible')) {
                $('#m_groupHelp').modal('toggle');
            }

            $('#cb_jenisanggotaR').focus();
        }
        $('#cus_flagkredit').val(member.cus_flagkredit);
        if (member.cus_flagkredit != 'Y') {
            $('#cus_creditlimit').prop('disabled', true);
            $('#cus_top').prop('disabled', true);
        }
        $('#cus_flagkredit').on('keyup', function () {
            if ($(this).val() == 'Y') {
                $('#cus_creditlimit').prop('disabled', false);
                $('#cus_top').prop('disabled', false);
            }else{
                $('#cus_creditlimit').prop('disabled', true);
                $('#cus_top').prop('disabled', true);
            }
        });
        $('#btn-rekam').on('click', function () {
            ok = cek_field_wajib();

            console.log(ok);

            // Validasi Suboutlet
            let outlet = $('#cus_kodeoutlet').val();
            if (outlet == 2 || outlet == 3 || outlet == 4 || outlet == 5) {
                let suboutlet = $('#cus_kodesuboutlet').val();
                if (!suboutlet) {
                    swal({
                        title: "{{__('Sub Outlet Tidak Boleh Kosong !!!')}}",
                        text: '',
                        icon: 'warning',
                        timer: 1000
                    })
                    $('#cus_kodesuboutlet').focus()
                    return false;
                }
            }

            if (!isApproved && member.cus_creditlimit != $('#cus_creditlimit').val()) {
                swal({
                    title: "{{__('Butuh approval untuk perubahan credit limit, data belum disimpan!')}}",
                    icon: 'warning'
                }).then(function () {
                    approvalMode = 'kredit';
                    $('#m_aktifnonaktif').modal('show');
                    $('#btn-aktifnonaktif-ok').show();
                    $('#btn-aktifnonaktif-ok').attr('disabled', false);
                    $('#btn-hapus-ok').hide();
                    $('#btn-hapus-ok').attr('disabled', true);
                })
            } else if (ok) {
                swal({
                    title: "{{__('Yakin ingin menyimpan data?')}}",
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

                        data.customer['cus_flag_ina'] = $('#cb_flag_ina').is(':checked') ? 'Y' : 'N';
                        data.keycustomer.push('cus_flag_ina');

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
                        } else data.customercrm['crm_jenisanggota'] = 'K';
                        data.keycustomercrm.push('crm_jenisanggota');

                        if ($('#cb_jeniskelaminL').is(':checked')) {
                            data.customercrm['crm_jeniskelamin'] = 'L';
                        } else data.customercrm['crm_jeniskelamin'] = 'P';
                        data.keycustomercrm.push('crm_jeniskelamin');

                        if ($('#i_pendidikanX').is(':visible')) {
                            data.customercrm['crm_pendidikanakhir'] = $('#i_pendidikanX').val();
                        } else data.customercrm['crm_pendidikanakhir'] = $('#i_pendidikan').val();
                        data.keycustomercrm.push('crm_pendidikanakhir');

                        if ($('#cb_internetY').is(':checked')) {
                            data.customercrm['crm_internet'] = 'Y';
                        } else data.customercrm['crm_internet'] = 'T';
                        data.keycustomercrm.push('crm_internet');

                        if ($('#c_metodekirimX').is(':visible')) {
                            data.customercrm['crm_metodekirim'] = $('#c_metodekirimX').val();
                        } else data.customercrm['crm_metodekirim'] = $('#c_metodekirim').val();
                        data.keycustomercrm.push('crm_metodekirim');

                        if ($('#cb_jenisbangunanP').is(':checked')) {
                            data.customercrm['crm_jenisbangunan'] = 'P';
                        } else if ($('#cb_jenisbangunanS').is(':checked')) {
                            data.customercrm['crm_jenisbangunan'] = 'S';
                        } else data.customercrm['crm_jenisbangunan'] = 'N';
                        data.keycustomercrm.push('crm_jenisbangunan');

                        if ($('#cb_statusbangunanM').is(':checked')) {
                            data.customercrm['crm_statusbangunan'] = 'M';
                            console.log("ini M");
                        } else data.customercrm['crm_statusbangunan'] = 'S';
                        data.keycustomercrm.push('crm_statusbangunan');

                        if ($('#cb_jeniskendaraanMotor').is(':checked')) {
                            if ($('#i_motorX').is(':visible'))
                                data.customercrm['crm_motor'] = $('#i_motorX').val();
                            else data.customercrm['crm_motor'] = $('#i_motor').val();
                        } else data.customercrm['crm_motor'] = '';
                        data.keycustomercrm.push('crm_motor');

                        if ($('#cb_jeniskendaraanMobil').is(':checked')) {
                            if ($('#i_mobilX').is(':visible'))
                                data.customercrm['crm_mobil'] = $('#i_mobilX').val();
                            else data.customercrm['crm_mobil'] = $('#i_mobil').val();
                        } else data.customercrm['crm_mobil'] = '';
                        data.keycustomercrm.push('crm_mobil');

                        data.customercrm['crm_idgroupkat'] = idgroupkat;
                        data.keycustomercrm.push('crm_idgroupkat');

                        if ($('#cus_flagmemberkhusus').val() == 'Y')
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
                            url: '{{ url()->current() }}/update-member',
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
                                $('#modal-loader').modal('hide');
                                if (response.status == 'success') {
                                    swal({
                                        title: response['message'],
                                        icon: "success"
                                    }).then(function () {
                                        $('#modal-loader').modal('hide');
                                    });
                                } else {
                                    swal({
                                        title: response.message,
                                        icon: "error"
                                    }).then(function () {
                                        $('#cus_kodemember').val(member.cus_kodemember);
                                        $('#cus_kodemember').select();
                                        $('#modal-loader').modal('hide');
                                    });

                                }
                            }
                        });
                    }
                });
            } else {
                swal({
                    title: "{{__('Data yang diinputkan belum lengkap!')}}",
                    text: ' ',
                    icon: "warning",
                    timer: 750,
                    buttons: false,
                }).then(function () {
                    $('#btn-' + $('.kosong').parent().parent().parent().parent().parent().parent().attr('id')).click();
                    $('.kosong').select();
                });
            }
        });

        $('#btn-aktif-nonaktif').on('click', function () {
            if (member.cus_kodeigr != '{{Session::get('kdigr')}}') {
                swal({
                    title: "{{__('Data yang akan diproses tidak sesuai dengan cabang anda!')}}",
                    icon: 'error'
                });
            } else {
                approvalMode = 'aktif-nonaktif';

                isValid = true;

                if (member.cus_recordid == '1') {
                    if (member.cus_flagmemberkhusus === 'Y') {
                        message = "{{__('Kode Anggota ')}}" + member.cus_kodemember + "{{__(' merupakan member merah, tidak dapat diaktifkan kembali!')}}";
                        status = '';
                        isValid = false;
                    } else {
                        message = "{{__('Kode Anggota ')}}" + member.cus_kodemember + "{{__(' dibuat aktif kembali?')}}";
                        status = '';
                    }
                } else {
                    message = "{{__('Kode Anggota ')}}" + member.cus_kodemember + "{{__(' dibuat tidak aktif?')}}";
                    status = '1';
                }

                if (isValid) {
                    swal({
                        title: message,
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((createData) => {
                        if (createData) {
                            $('#m_aktifnonaktif').modal('toggle');
                            $('#btn-aktifnonaktif-ok').show();
                            $('#btn-aktifnonaktif-ok').attr('disabled', false);
                            $('#btn-hapus-ok').hide();
                            $('#btn-hapus-ok').attr('disabled', true);
                        }
                    });
                } else {
                    swal({
                        title: message,
                        icon: "error",
                    }).then((createData) => {

                    });
                }
            }
        });

        $('#m_aktifnonaktif').on('shown.bs.modal', function () {
            $('#i_username').select();
        });

        $('#m_aktifnonaktif').on('hide.bs.modal', function () {
            $('#i_username').val('');
            $('#i_password').val('');
        });

        $('#btn-export-crm').on('click', function () {
            swal({
                title: "{{__('Apabila ada perubahan data, pastikan sudah disimpan sebelum diexport ke CRM! Lanjut export?')}}",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((createData) => {
                if (createData) {
                    $.ajax({
                        url: '{{ url()->current() }}/export-crm',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {kodemember: member.cus_kodemember},
                        beforeSend: function () {
                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        },
                        success: function (response) {
                            console.log(response);
                            $('#modal-loader').modal('hide');
                            if (response.status == 'success') {
                                swal({
                                    title: response['message'],
                                    icon: "success"
                                }).then(function () {
                                    $('#modal-loader').modal('hide');
                                });
                            } else {
                                swal({
                                    title: response.message,
                                    icon: "error"
                                }).then(function () {
                                    $('#cus_kodemember').val(member.cus_kodemember);
                                    $('#cus_kodemember').select();
                                    $('#modal-loader').modal('hide');
                                });

                            }
                        }, error: function (err) {
                            $('#modal-loader').modal('hide');
                            console.log(err.responseJSON.message.substr(0, 100));
                            alertError(err.statusText, err.responseJSON.message);
                        }
                    });
                }
            });
        });

        $('#btn-quisioner').on('click', function () {
            $('#m_quisioner').modal('toggle');

            $('#q_kodemember').prop('disabled', true);
            $('#q_namamember').prop('disabled', true);

            $('#q_kodemember').val(member.cus_kodemember);
            $('#q_namamember').val(member.cus_namamember);
        });

        $('#btn-q-save').on('click', function (event) {
            event.preventDefault();

            var data = {};
            var arrdata = [];
            var pass = true;
            var name;

            $('tr[id^="q_"]').each(function () {
                // console.log($(this).find('.dijual').val());
                var data = {};

                data['fpm_kodemember'] = member.cus_kodemember;
                data['fpm_kodeprdcd'] = $(this).attr('id').substr(2);

                if ($(this).find('.dijual').val() == 'Y')
                    dijual = 'T';
                else dijual = 'F';

                if (dijual == 'F') {
                    beliigr = 'F';
                    belilain = 'F';
                    $(this).find('.beli-igr').val('');
                    $(this).find('.beli-lain').val('');
                } else {
                    if ($(this).find('.beli-igr').val() == 'Y')
                        beliigr = 'T';
                    else beliigr = 'F';

                    if ($(this).find('.beli-lain').val() == 'Y')
                        belilain = 'T';
                    else belilain = 'F';
                }

                if (dijual == 'T' && beliigr == 'F' && belilain == 'F') {
                    pass = false;
                    name = $(this).find('td').html();
                    return false;
                }

                data['fpm_flagjual'] = dijual;
                data['fpm_flagbeliigr'] = beliigr;
                data['fpm_flagbelilain'] = belilain;

                arrdata.push(data);
            });

            if (!pass) {
                swal({
                    title: "{{__('Kolom Beli di IGR atau Beli Tempat Lain untuk ')}}" + name + "{{__(' harus diisi!')}}",
                    icon: 'warning',
                    timer: 1000
                }).then(() => {
                    $(this).find('.beli-igr').focus();
                });
            } else {
                swal({
                    title: "{{__('Yakin ingin menyimpan data?')}}",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                }).then((createData) => {
                    if (createData) {
                        $.ajax({
                            url: '{{ url()->current() }}/save-quisioner',
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
                                    }).then(function () {
                                        $('#modal-loader').modal('hide');
                                    });
                                } else {
                                    swal({
                                        title: response.message,
                                        icon: "error"
                                    }).then(function () {
                                        $('#modal-loader').modal('hide');
                                        $('#cus_kodemember').val(member.cus_kodemember);
                                        $('#cus_kodemember').select();
                                    });

                                }
                            }
                        });
                    }
                });
            }
        });

        $('#btn-hapus').on('click', function () {
            if (member.cus_kodeigr != '{{Session::get('kdigr')}}') {
                swal({
                    title: "{{__('Data yang akan diproses tidak sesuai dengan cabang anda!')}}",
                    icon: "error"
                });
            } else {
                swal({
                    title: "{{__('Kode anggota ')}}" + member.cus_kodemember + "{{__(' dihapus permanen?')}}",
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then((createData) => {
                    if (createData) {
                        $('#m_aktifnonaktif').modal('toggle');
                        $('#btn-aktifnonaktif-ok').hide();
                        $('#btn-aktifnonaktif-ok').attr('disabled', true);
                        $('#btn-hapus-ok').show();
                        $('#btn-hapus-ok').attr('disabled', false);
                        // swal({
                        //     title: " ",
                        //     text: " ",
                        //     buttons: true,
                        //     dangerMode: true,
                        //     content: {
                        //         element: "input",
                        //         attributes: {
                        //             placeholder: "Inputkan user",
                        //             type: "text",
                        //         },
                        //         element: "input",
                        //         attributes: {
                        //             placeholder: "Inputkan password",
                        //             type: "password",
                        //         },
                        //     }
                        // }).then((password) => {
                        //     if (password) {
                        //         $.ajax({
                        //             url: '{{ url()->current() }}/check_password',
                        //             type: 'POST',
                        //             headers: {
                        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        //             },
                        //             data: {username: 'VBU', password: password},
                        //             beforeSend: function(){
                        //                 $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        //             },
                        //             success: function (response) {
                        //                 if(response == 'ok'){
                        //                     $.ajax({
                        //                         url: '{{ url()->current() }}/hapus_member',
                        //                         type: 'POST',
                        //                         headers: {
                        //                             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        //                         },
                        //                         data: {kodemember: member.cus_kodemember},
                        //                         success: function (response) {
                        //                             $('#modal-loader').modal('hide');
                        //                             if (response.status == 'success') {
                        //                                 swal({
                        //                                     title: response['message'],
                        //                                     icon: "success"
                        //                                 }).then((createData) => {
                        //                                     initial();
                        //                                 });
                        //
                        //                             }
                        //                             else {
                        //                                 swal({
                        //                                     title: response.message,
                        //                                     icon: "error"
                        //                                 });
                        //
                        //                             }
                        //                         }
                        //                     });
                        //                 }
                        //                 else{
                        //                     $('#modal-loader').modal('hide');
                        //                     swal({
                        //                         title: "Password salah!",
                        //                         icon: "error"
                        //                     });
                        //                 }
                        //             }
                        //         });
                        //     }
                        // });
                    }
                });
            }
        });

        $('#btn-download-mktho').on('click', function () {
            $.ajax({
                url: '{{ url()->current() }}/download-mktho',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {},
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (response) {
                    $('#modal-loader').modal('hide')
                    if (response.kode == 1) {
                        Swal({
                            title: response.msg,
                            icon: 'succcess'
                        }).then(function () {
                            $('#modal-loader').modal('hide');
                        });
                        // swal(response.msg,'','success')
                    } else {
                        Swal({
                            title: 'Warning',
                            text: response.msg,
                            icon: 'error',
                        }).then(function () {
                            $('#modal-loader').modal('hide');
                        });
                        // alertError('Warning', response.msg, 'warning');
                    }
                }, error: function (err) {
                    $('#modal-loader').modal('hide')
                    console.log(err.responseJSON.message.substr(0, 100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            });
        });

        $('#btn-check-registrasi').on('click', function () {
            $.ajax({
                url: '{{ url()->current() }}/check-registrasi',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, data: {
                    kodemember: $('#cus_kodemember').val()
                }, beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                }, success: function (response) {
                    $('#modal-loader').modal('hide')
                    if (response.kode == 1) {
                        swal(response.msg, '', 'success').then(function () {
                            $('#modal-loader').modal('hide');
                        });
                    } else {
                        Swal({
                            title: 'Warning',
                            text: response.msg,
                            icon: 'warning'
                        }).then(function () {
                            $('#modal-loader').modal('hide');
                        });
                        // alertError('Warning', response.msg, 'warning');
                    }
                }, error: function (err) {
                    $('#modal-loader').modal('hide')
                    console.log(err.responseJSON.message.substr(0, 100));
                    Swal({
                        title: err.statusText,
                        text: err.responseJSON.message,
                        icon: 'error'
                    }).then(function () {
                        $('#modal-loader').modal('hide');
                    });
                    // alertError(err.statusText, err.responseJSON.message);
                }
            })
        });

        $('#i_username').on('keypress', function (event) {
            if (event.which == 13 && $(this).val().length > 0) {
                $('#i_password').select();
            }
        });

        $('#i_password').on('keypress', function (event) {
            if (event.which == 13 && $(this).val().length > 0) {
                if ($('#btn-aktifnonaktif-ok').attr('disabled') == 'disabled') {
                    $('#btn-hapus-ok').click();
                } else {
                    $('#btn-aktifnonaktif-ok').click();
                }
            }
        })

        $('#btn-aktifnonaktif-ok').on('click', function () {
            user = $('#i_username').val();
            pass = $('#i_password').val();
            aktif_nonaktif(user, pass);
        })

        $('#btn-hapus-ok').on('click', function () {
            user = $('#i_username').val();
            pass = $('#i_password').val();
            hapus(user, pass);
        })

        function aktif_nonaktif(user, pass) {
            $.ajax({
                url: '{{ url()->current() }}/check-password',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {username: user, password: pass},
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    if (response == 'ok') {
                        if (approvalMode == 'aktif-nonaktif') {
                            $.ajax({
                                url: '{{ url()->current() }}/set-status-member',
                                type: 'GET',
                                data: {"_token": "{{ csrf_token() }}", kode: member.cus_kodemember, status: status},
                                success: function (response) {
                                    $('#modal-loader').modal('hide');
                                    $('#m_aktifnonaktif').modal('hide');
                                    if (response == 'success') {
                                        swal({
                                            title: "{{__('Berhasil mengubah status member!')}}",
                                            icon: "success"
                                        }).then(function () {
                                            if (status == '') {
                                                member.cus_recordid = status;
                                                $('#i_statusmember').val('AKTIF');
                                            } else if (status == '1') {
                                                member.cus_recordid = status;
                                                $('#i_statusmember').val('NON-AKTIF');
                                            }
                                        });
                                    } else {
                                        swal({
                                            title: "{{__('Gagal mengubah status member!')}}",
                                            icon: "error"
                                        });
                                    }
                                }
                            });
                        } else if (approvalMode == 'kredit') {
                            isApproved = true;

                            swal({
                                title: "{{__('Perubahan credit limit disetujui, silahkan menyimpan data!')}}",
                                icon: 'success'
                            }).then(function () {
                                $('#m_aktifnonaktif').modal('hide');
                                $('#modal-loader').modal('hide');
                            });
                        }
                    } else {
                        isApproved = false;
                        console.log(response);
                        if (response == 'userlevel') {
                            swal({
                                title: "{{__('Anda tidak berhak melakukan approval!')}}",
                                icon: "error"
                            }).then(function () {
                                $('#i_password').select();
                                $('#modal-loader').modal('hide');
                            });
                        } else {
                            swal({
                                title: "{{__('Username atau password salah!')}}",
                                icon: "error"
                            }).then(function () {
                                $('#modal-loader').modal('hide');
                                $('#i_password').select();
                            });
                        }
                    }
                }
            });
        }

        function hapus(user, password) {
            console.log('hapus');
            $.ajax({
                url: '{{ url()->current() }}/check-password',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {username: user, password: password},
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (response) {
                    if (response == 'ok') {
                        $.ajax({
                            url: '{{ url()->current() }}/delete-member',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {kodemember: member.cus_kodemember},
                            success: function (response) {
                                $('#m_aktifnonaktif').modal('hide');
                                $('#modal-loader').modal('hide');
                                if (response.status == 'success') {
                                    swal({
                                        title: response['message'],
                                        icon: "success"
                                    }).then((createData) => {
                                        $('#modal-loader').modal('hide');
                                        initial();
                                    });

                                } else {
                                    swal({
                                        title: response.message,
                                        icon: "error"
                                    });

                                }
                            }
                        });
                    } else {
                        $('#modal-loader').modal('hide');
                        console.log(response);
                        if (response == 'userlevel') {
                            swal({
                                title: "{{__('Anda tidak berhak melakukan approval!')}}",
                                icon: "error"
                            }).then(function () {
                                $('#modal-loader').modal('hide');
                                $('#i_password').select();
                            });
                        } else {
                            swal({
                                title: "{{__('Username atau password salah!')}}",
                                icon: "error"
                            }).then(function () {
                                $('#modal-loader').modal('hide');
                                $('#i_password').select();
                            });
                        }
                    }
                }
            });
        }
    </script>
@endsection
